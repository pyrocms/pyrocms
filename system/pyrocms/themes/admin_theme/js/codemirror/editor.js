/* The Editor object manages the content of the editable frame. It
 * catches events, colours nodes, and indents lines. This file also
 * holds some functions for transforming arbitrary DOM structures into
 * plain sequences of <span> and <br> elements
 */

var internetExplorer = document.selection && window.ActiveXObject && /MSIE/.test(navigator.userAgent);
var webkit = /AppleWebKit/.test(navigator.userAgent);
var safari = /Apple Computers, Inc/.test(navigator.vendor);
var gecko = /gecko\/(\d{8})/i.test(navigator.userAgent);

// Make sure a string does not contain two consecutive 'collapseable'
// whitespace characters.
function makeWhiteSpace(n) {
  var buffer = [], nb = true;
  for (; n > 0; n--) {
    buffer.push((nb || n == 1) ? nbsp : " ");
    nb = !nb;
  }
  return buffer.join("");
}

// Create a set of white-space characters that will not be collapsed
// by the browser, but will not break text-wrapping either.
function fixSpaces(string) {
  if (string.charAt(0) == " ") string = nbsp + string.slice(1);
  return string.replace(/\t/g, function(){return makeWhiteSpace(indentUnit);})
    .replace(/[ \u00a0]{2,}/g, function(s) {return makeWhiteSpace(s.length);});
}

function cleanText(text) {
  return text.replace(/\u00a0/g, " ").replace(/\u200b/g, "");
}

// Create a SPAN node with the expected properties for document part
// spans.
function makePartSpan(value, doc) {
  var text = value;
  if (value.nodeType == 3) text = value.nodeValue;
  else value = doc.createTextNode(text);

  var span = doc.createElement("SPAN");
  span.isPart = true;
  span.appendChild(value);
  span.currentText = text;
  return span;
}

// On webkit, when the last BR of the document does not have text
// behind it, the cursor can not be put on the line after it. This
// makes pressing enter at the end of the document occasionally do
// nothing (or at least seem to do nothing). To work around it, this
// function makes sure the document ends with a span containing a
// zero-width space character. The traverseDOM iterator filters such
// character out again, so that the parsers won't see them. This
// function is called from a few strategic places to make sure the
// zwsp is restored after the highlighting process eats it.
var webkitLastLineHack = webkit ?
  function(container) {
    var last = container.lastChild;
    if (!last || !last.isPart || last.textContent != "\u200b")
      container.appendChild(makePartSpan("\u200b", container.ownerDocument));
  } : function() {};

var Editor = (function(){
  // The HTML elements whose content should be suffixed by a newline
  // when converting them to flat text.
  var newlineElements = {"P": true, "DIV": true, "LI": true};

  function asEditorLines(string) {
    var tab = makeWhiteSpace(indentUnit);
    return map(string.replace(/\t/g, tab).replace(/\u00a0/g, " ").replace(/\r\n?/g, "\n").split("\n"), fixSpaces);
  }

  // Helper function for traverseDOM. Flattens an arbitrary DOM node
  // into an array of textnodes and <br> tags.
  function simplifyDOM(root, atEnd) {
    var doc = root.ownerDocument;
    var result = [];
    var leaving = true;

    function simplifyNode(node, top) {
      if (node.nodeType == 3) {
        var text = node.nodeValue = fixSpaces(node.nodeValue.replace(/[\r\u200b]/g, "").replace(/\n/g, " "));
        if (text.length) leaving = false;
        result.push(node);
      }
      else if (isBR(node) && node.childNodes.length == 0) {
        leaving = true;
        result.push(node);
      }
      else {
        for (var n = node.firstChild; n; n = n.nextSibling) simplifyNode(n);
        if (!leaving && newlineElements.hasOwnProperty(node.nodeName.toUpperCase())) {
          leaving = true;
          if (!atEnd || !top)
            result.push(doc.createElement("BR"));
        }
      }
    }

    simplifyNode(root, true);
    return result;
  }

  // Creates a MochiKit-style iterator that goes over a series of DOM
  // nodes. The values it yields are strings, the textual content of
  // the nodes. It makes sure that all nodes up to and including the
  // one whose text is being yielded have been 'normalized' to be just
  // <span> and <br> elements.
  function traverseDOM(start){
    var owner = start.ownerDocument;
    var nodeQueue = [];

    // Create a function that can be used to insert nodes after the
    // one given as argument.
    function pointAt(node){
      var parent = node.parentNode;
      var next = node.nextSibling;
      return function(newnode) {
        parent.insertBefore(newnode, next);
      };
    }
    var point = null;

    // This an Opera-specific hack -- always insert an empty span
    // between two BRs, because Opera's cursor code gets terribly
    // confused when the cursor is between two BRs.
    var afterBR = true;

    // Insert a normalized node at the current point. If it is a text
    // node, wrap it in a <span>, and give that span a currentText
    // property -- this is used to cache the nodeValue, because
    // directly accessing nodeValue is horribly slow on some browsers.
    // The dirty property is used by the highlighter to determine
    // which parts of the document have to be re-highlighted.
    function insertPart(part){
      var text = "\n";
      if (part.nodeType == 3) {
        select.snapshotChanged();
        part = makePartSpan(part, owner);
        text = part.currentText;
        afterBR = false;
      }
      else {
        if (afterBR && window.opera)
          point(makePartSpan("", owner));
        afterBR = true;
      }
      part.dirty = true;
      nodeQueue.push(part);
      point(part);
      return text;
    }

    // Extract the text and newlines from a DOM node, insert them into
    // the document, and return the textual content. Used to replace
    // non-normalized nodes.
    function writeNode(node, end) {
      var simplified = simplifyDOM(node, end);
      for (var i = 0; i < simplified.length; i++)
        simplified[i] = insertPart(simplified[i]);
      return simplified.join("");
    }

    // Check whether a node is a normalized <span> element.
    function partNode(node){
      if (node.isPart && node.childNodes.length == 1 && node.firstChild.nodeType == 3) {
        node.currentText = node.firstChild.nodeValue;
        return !/[\n\t\r]/.test(node.currentText);
      }
      return false;
    }

    // Advance to next node, return string for current node.
    function next() {
      if (!start) throw StopIteration;
      var node = start;
      start = node.nextSibling;

      if (partNode(node)){
        nodeQueue.push(node);
        afterBR = false;
        return node.currentText;
      }
      else if (isBR(node)) {
        if (afterBR && window.opera)
          node.parentNode.insertBefore(makePartSpan("", owner), node);
        nodeQueue.push(node);
        afterBR = true;
        return "\n";
      }
      else {
        var end = !node.nextSibling;
        point = pointAt(node);
        removeElement(node);
        return writeNode(node, end);
      }
    }

    // MochiKit iterators are objects with a next function that
    // returns the next value or throws StopIteration when there are
    // no more values.
    return {next: next, nodes: nodeQueue};
  }

  // Determine the text size of a processed node.
  function nodeSize(node) {
    return isBR(node) ? 1 : node.currentText.length;
  }

  // Search backwards through the top-level nodes until the next BR or
  // the start of the frame.
  function startOfLine(node) {
    while (node && !isBR(node)) node = node.previousSibling;
    return node;
  }
  function endOfLine(node, container) {
    if (!node) node = container.firstChild;
    else if (isBR(node)) node = node.nextSibling;

    while (node && !isBR(node)) node = node.nextSibling;
    return node;
  }

  function time() {return new Date().getTime();}

  // Client interface for searching the content of the editor. Create
  // these by calling CodeMirror.getSearchCursor. To use, call
  // findNext on the resulting object -- this returns a boolean
  // indicating whether anything was found, and can be called again to
  // skip to the next find. Use the select and replace methods to
  // actually do something with the found locations.
  function SearchCursor(editor, string, fromCursor, caseFold) {
    this.editor = editor;
    if (caseFold == undefined) {
      caseFold = (string == string.toLowerCase());
    }
    this.caseFold = caseFold;
    if (caseFold) string = string.toLowerCase();
    this.history = editor.history;
    this.history.commit();

    // Are we currently at an occurrence of the search string?
    this.atOccurrence = false;
    // The object stores a set of nodes coming after its current
    // position, so that when the current point is taken out of the
    // DOM tree, we can still try to continue.
    this.fallbackSize = 15;
    var cursor;
    // Start from the cursor when specified and a cursor can be found.
    if (fromCursor && (cursor = select.cursorPos(this.editor.container))) {
      this.line = cursor.node;
      this.offset = cursor.offset;
    }
    else {
      this.line = null;
      this.offset = 0;
    }
    this.valid = !!string;

    // Create a matcher function based on the kind of string we have.
    var target = string.split("\n"), self = this;
    this.matches = (target.length == 1) ?
      // For one-line strings, searching can be done simply by calling
      // indexOf on the current line.
      function() {
        var line = cleanText(self.history.textAfter(self.line).slice(self.offset));
        var match = (self.caseFold ? line.toLowerCase() : line).indexOf(string);
        if (match > -1)
          return {from: {node: self.line, offset: self.offset + match},
                  to: {node: self.line, offset: self.offset + match + string.length}};
      } :
      // Multi-line strings require internal iteration over lines, and
      // some clunky checks to make sure the first match ends at the
      // end of the line and the last match starts at the start.
      function() {
        var firstLine = cleanText(self.history.textAfter(self.line).slice(self.offset));
        var match = (self.caseFold ? firstLine.toLowerCase() : firstLine).lastIndexOf(target[0]);
        if (match == -1 || match != firstLine.length - target[0].length)
          return false;
        var startOffset = self.offset + match;

        var line = self.history.nodeAfter(self.line);
        for (var i = 1; i < target.length - 1; i++) {
          var lineText = cleanText(self.history.textAfter(line));
          if ((self.caseFold ? lineText.toLowerCase() : lineText) != target[i])
            return false;
          line = self.history.nodeAfter(line);
        }

        var lastLine = cleanText(self.history.textAfter(line));
        if ((self.caseFold ? lastLine.toLowerCase() : lastLine).indexOf(target[target.length - 1]) != 0)
          return false;

        return {from: {node: self.line, offset: startOffset},
                to: {node: line, offset: target[target.length - 1].length}};
      };
  }

  SearchCursor.prototype = {
    findNext: function() {
      if (!this.valid) return false;
      this.atOccurrence = false;
      var self = this;

      // Go back to the start of the document if the current line is
      // no longer in the DOM tree.
      if (this.line && !this.line.parentNode) {
        this.line = null;
        this.offset = 0;
      }

      // Set the cursor's position one character after the given
      // position.
      function saveAfter(pos) {
        if (self.history.textAfter(pos.node).length > pos.offset) {
          self.line = pos.node;
          self.offset = pos.offset + 1;
        }
        else {
          self.line = self.history.nodeAfter(pos.node);
          self.offset = 0;
        }
      }

      while (true) {
        var match = this.matches();
        // Found the search string.
        if (match) {
          this.atOccurrence = match;
          saveAfter(match.from);
          return true;
        }
        this.line = this.history.nodeAfter(this.line);
        this.offset = 0;
        // End of document.
        if (!this.line) {
          this.valid = false;
          return false;
        }
      }
    },

    select: function() {
      if (this.atOccurrence) {
        select.setCursorPos(this.editor.container, this.atOccurrence.from, this.atOccurrence.to);
        select.scrollToCursor(this.editor.container);
      }
    },

    replace: function(string) {
      if (this.atOccurrence) {
        var end = this.editor.replaceRange(this.atOccurrence.from, this.atOccurrence.to, string);
        this.line = end.node;
        this.offset = end.offset;
        this.atOccurrence = false;
      }
    }
  };

  // The Editor object is the main inside-the-iframe interface.
  function Editor(options) {
    this.options = options;
    window.indentUnit = options.indentUnit;
    this.parent = parent;
    this.doc = document;
    var container = this.container = this.doc.body;
    this.win = window;
    this.history = new UndoHistory(container, options.undoDepth, options.undoDelay, this);
    var self = this;

    if (!Editor.Parser)
      throw "No parser loaded.";
    if (options.parserConfig && Editor.Parser.configure)
      Editor.Parser.configure(options.parserConfig);

    if (!options.readOnly)
      select.setCursorPos(container, {node: null, offset: 0});

    this.dirty = [];
    this.importCode(options.content || "");
    this.history.onChange = options.onChange;

    if (!options.readOnly) {
      if (options.continuousScanning !== false) {
        this.scanner = this.documentScanner(options.passTime);
        this.delayScanning();
      }

      function setEditable() {
        // Use contentEditable instead of designMode on IE, since designMode frames
        // can not run any scripts. It would be nice if we could use contentEditable
        // everywhere, but it is significantly flakier than designMode on every
        // single non-IE browser.
        if (document.body.contentEditable != undefined && internetExplorer)
          document.body.contentEditable = "true";
        else
          document.designMode = "on";

        document.documentElement.style.borderWidth = "0";
        if (!options.textWrapping)
          container.style.whiteSpace = "nowrap";
      }

      // If setting the frame editable fails, try again when the user
      // focus it (happens when the frame is not visible on
      // initialisation, in Firefox).
      try {
        setEditable();
      }
      catch(e) {
        var focusEvent = addEventHandler(document, "focus", function() {
          focusEvent();
          setEditable();
        }, true);
      }

      addEventHandler(document, "keydown", method(this, "keyDown"));
      addEventHandler(document, "keypress", method(this, "keyPress"));
      addEventHandler(document, "keyup", method(this, "keyUp"));

      function cursorActivity() {self.cursorActivity(false);}
      addEventHandler(document.body, "mouseup", cursorActivity);
      addEventHandler(document.body, "cut", cursorActivity);

      // workaround for a gecko bug [?] where going forward and then
      // back again breaks designmode (no more cursor)
      if (gecko)
        addEventHandler(this.win, "pagehide", function(){self.unloaded = true;});

      addEventHandler(document.body, "paste", function(event) {
        cursorActivity();
        var text = null;
        try {
          var clipboardData = event.clipboardData || window.clipboardData;
          if (clipboardData) text = clipboardData.getData('Text');
        }
        catch(e) {}
        if (text !== null) {
          event.stop();
          self.replaceSelection(text);
          select.scrollToCursor(self.container);
        }
      });

      if (this.options.autoMatchParens)
        addEventHandler(document.body, "click", method(this, "scheduleParenHighlight"));
    }
    else if (!options.textWrapping) {
      container.style.whiteSpace = "nowrap";
    }
  }

  function isSafeKey(code) {
    return (code >= 16 && code <= 18) || // shift, control, alt
           (code >= 33 && code <= 40); // arrows, home, end
  }

  Editor.prototype = {
    // Import a piece of code into the editor.
    importCode: function(code) {
      this.history.push(null, null, asEditorLines(code));
      this.history.reset();
    },

    // Extract the code from the editor.
    getCode: function() {
      if (!this.container.firstChild)
        return "";

      var accum = [];
      select.markSelection(this.win);
      forEach(traverseDOM(this.container.firstChild), method(accum, "push"));
      webkitLastLineHack(this.container);
      select.selectMarked();
      return cleanText(accum.join(""));
    },

    checkLine: function(node) {
      if (node === false || !(node == null || node.parentNode == this.container))
        throw parent.CodeMirror.InvalidLineHandle;
    },

    cursorPosition: function(start) {
      if (start == null) start = true;
      var pos = select.cursorPos(this.container, start);
      if (pos) return {line: pos.node, character: pos.offset};
      else return {line: null, character: 0};
    },

    firstLine: function() {
      return null;
    },

    lastLine: function() {
      if (this.container.lastChild) return startOfLine(this.container.lastChild);
      else return null;
    },

    nextLine: function(line) {
      this.checkLine(line);
      var end = endOfLine(line, this.container);
      return end || false;
    },

    prevLine: function(line) {
      this.checkLine(line);
      if (line == null) return false;
      return startOfLine(line.previousSibling);
    },

    visibleLineCount: function() {
      var line = this.container.firstChild;
      while (line && isBR(line)) line = line.nextSibling; // BR heights are unreliable
      if (!line) return false;
      var innerHeight = (window.innerHeight
                         || document.documentElement.clientHeight
                         || document.body.clientHeight);
      return Math.floor(innerHeight / line.offsetHeight);
    },

    selectLines: function(startLine, startOffset, endLine, endOffset) {
      this.checkLine(startLine);
      var start = {node: startLine, offset: startOffset}, end = null;
      if (endOffset !== undefined) {
        this.checkLine(endLine);
        end = {node: endLine, offset: endOffset};
      }
      select.setCursorPos(this.container, start, end);
      select.scrollToCursor(this.container);
    },

    lineContent: function(line) {
      var accum = [];
      for (line = line ? line.nextSibling : this.container.firstChild;
           line && !isBR(line); line = line.nextSibling)
        accum.push(nodeText(line));
      return cleanText(accum.join(""));
    },

    setLineContent: function(line, content) {
      this.history.commit();
      this.replaceRange({node: line, offset: 0},
                        {node: line, offset: this.history.textAfter(line).length},
                        content);
      this.addDirtyNode(line);
      this.scheduleHighlight();
    },

    removeLine: function(line) {
      var node = line ? line.nextSibling : this.container.firstChild;
      while (node) {
        var next = node.nextSibling;
        removeElement(node);
        if (isBR(node)) break;
        node = next;
      }
      this.addDirtyNode(line);
      this.scheduleHighlight();
    },

    insertIntoLine: function(line, position, content) {
      var before = null;
      if (position == "end") {
        before = endOfLine(line, this.container);
      }
      else {
        for (var cur = line ? line.nextSibling : this.container.firstChild; cur; cur = cur.nextSibling) {
          if (position == 0) {
            before = cur;
            break;
          }
          var text = nodeText(cur);
          if (text.length > position) {
            before = cur.nextSibling;
            content = text.slice(0, position) + content + text.slice(position);
            removeElement(cur);
            break;
          }
          position -= text.length;
        }
      }

      var lines = asEditorLines(content), doc = this.container.ownerDocument;
      for (var i = 0; i < lines.length; i++) {
        if (i > 0) this.container.insertBefore(doc.createElement("BR"), before);
        this.container.insertBefore(makePartSpan(lines[i], doc), before);
      }
      this.addDirtyNode(line);
      this.scheduleHighlight();
    },

    // Retrieve the selected text.
    selectedText: function() {
      var h = this.history;
      h.commit();

      var start = select.cursorPos(this.container, true),
          end = select.cursorPos(this.container, false);
      if (!start || !end) return "";

      if (start.node == end.node)
        return h.textAfter(start.node).slice(start.offset, end.offset);

      var text = [h.textAfter(start.node).slice(start.offset)];
      for (var pos = h.nodeAfter(start.node); pos != end.node; pos = h.nodeAfter(pos))
        text.push(h.textAfter(pos));
      text.push(h.textAfter(end.node).slice(0, end.offset));
      return cleanText(text.join("\n"));
    },

    // Replace the selection with another piece of text.
    replaceSelection: function(text) {
      this.history.commit();

      var start = select.cursorPos(this.container, true),
          end = select.cursorPos(this.container, false);
      if (!start || !end) return;

      end = this.replaceRange(start, end, text);
      select.setCursorPos(this.container, end);
      webkitLastLineHack(this.container);
    },

    reroutePasteEvent: function() {
      if (this.capturingPaste || window.opera) return;
      this.capturingPaste = true;
      var te = window.frameElement.CodeMirror.textareaHack;
      parent.focus();
      te.value = "";
      te.focus();

      var self = this;
      this.parent.setTimeout(function() {
        self.capturingPaste = false;
        self.win.focus();
        if (self.selectionSnapshot) // IE hack
          self.win.select.setBookmark(self.container, self.selectionSnapshot);
        var text = te.value;
        if (text) {
          self.replaceSelection(text);
          select.scrollToCursor(self.container);
        }
      }, 10);
    },

    replaceRange: function(from, to, text) {
      var lines = asEditorLines(text);
      lines[0] = this.history.textAfter(from.node).slice(0, from.offset) + lines[0];
      var lastLine = lines[lines.length - 1];
      lines[lines.length - 1] = lastLine + this.history.textAfter(to.node).slice(to.offset);
      var end = this.history.nodeAfter(to.node);
      this.history.push(from.node, end, lines);
      return {node: this.history.nodeBefore(end),
              offset: lastLine.length};
    },

    getSearchCursor: function(string, fromCursor, caseFold) {
      return new SearchCursor(this, string, fromCursor, caseFold);
    },

    // Re-indent the whole buffer
    reindent: function() {
      if (this.container.firstChild)
        this.indentRegion(null, this.container.lastChild);
    },

    reindentSelection: function(direction) {
      if (!select.somethingSelected(this.win)) {
        this.indentAtCursor(direction);
      }
      else {
        var start = select.selectionTopNode(this.container, true),
            end = select.selectionTopNode(this.container, false);
        if (start === false || end === false) return;
        this.indentRegion(start, end, direction);
      }
    },

    grabKeys: function(eventHandler, filter) {
      this.frozen = eventHandler;
      this.keyFilter = filter;
    },
    ungrabKeys: function() {
      this.frozen = "leave";
    },

    setParser: function(name, parserConfig) {
      Editor.Parser = window[name];
      parserConfig = parserConfig || this.options.parserConfig;
      if (parserConfig && Editor.Parser.configure)
        Editor.Parser.configure(parserConfig);

      if (this.container.firstChild) {
        forEach(this.container.childNodes, function(n) {
          if (n.nodeType != 3) n.dirty = true;
        });
        this.addDirtyNode(this.firstChild);
        this.scheduleHighlight();
      }
    },

    // Intercept enter and tab, and assign their new functions.
    keyDown: function(event) {
      if (this.frozen == "leave") {this.frozen = null; this.keyFilter = null;}
      if (this.frozen && (!this.keyFilter || this.keyFilter(event.keyCode, event))) {
        event.stop();
        this.frozen(event);
        return;
      }

      var code = event.keyCode;
      // Don't scan when the user is typing.
      this.delayScanning();
      // Schedule a paren-highlight event, if configured.
      if (this.options.autoMatchParens)
        this.scheduleParenHighlight();

      // The various checks for !altKey are there because AltGr sets both
      // ctrlKey and altKey to true, and should not be recognised as
      // Control.
      if (code == 13) { // enter
        if (event.ctrlKey && !event.altKey) {
          this.reparseBuffer();
        }
        else {
          select.insertNewlineAtCursor(this.win);
          this.indentAtCursor();
          select.scrollToCursor(this.container);
        }
        event.stop();
      }
      else if (code == 9 && this.options.tabMode != "default" && !event.ctrlKey) { // tab
        this.handleTab(!event.shiftKey);
        event.stop();
      }
      else if (code == 32 && event.shiftKey && this.options.tabMode == "default") { // space
        this.handleTab(true);
        event.stop();
      }
      else if (code == 36 && !event.shiftKey && !event.ctrlKey) { // home
        if (this.home()) event.stop();
      }
      else if (code == 35 && !event.shiftKey && !event.ctrlKey) { // end
        if (this.end()) event.stop();
      }
      // Only in Firefox is the default behavior for PgUp/PgDn correct.
      else if (code == 33 && !event.shiftKey && !event.ctrlKey && !gecko) { // PgUp
        if (this.pageUp()) event.stop();
      }
      else if (code == 34 && !event.shiftKey && !event.ctrlKey && !gecko) {  // PgDn
        if (this.pageDown()) event.stop();
      }
      else if ((code == 219 || code == 221) && event.ctrlKey && !event.altKey) { // [, ]
        this.highlightParens(event.shiftKey, true);
        event.stop();
      }
      else if (event.metaKey && !event.shiftKey && (code == 37 || code == 39)) { // Meta-left/right
        var cursor = select.selectionTopNode(this.container);
        if (cursor === false || !this.container.firstChild) return;

        if (code == 37) select.focusAfterNode(startOfLine(cursor), this.container);
        else {
          var end = endOfLine(cursor, this.container);
          select.focusAfterNode(end ? end.previousSibling : this.container.lastChild, this.container);
        }
        event.stop();
      }
      else if ((event.ctrlKey || event.metaKey) && !event.altKey) {
        if ((event.shiftKey && code == 90) || code == 89) { // shift-Z, Y
          select.scrollToNode(this.history.redo());
          event.stop();
        }
        else if (code == 90 || (safari && code == 8)) { // Z, backspace
          select.scrollToNode(this.history.undo());
          event.stop();
        }
        else if (code == 83 && this.options.saveFunction) { // S
          this.options.saveFunction();
          event.stop();
        }
        else if (internetExplorer && code == 86) {
          this.reroutePasteEvent();
        }
      }
    },

    // Check for characters that should re-indent the current line,
    // and prevent Opera from handling enter and tab anyway.
    keyPress: function(event) {
      var electric = Editor.Parser.electricChars, self = this;
      // Hack for Opera, and Firefox on OS X, in which stopping a
      // keydown event does not prevent the associated keypress event
      // from happening, so we have to cancel enter and tab again
      // here.
      if ((this.frozen && (!this.keyFilter || this.keyFilter(event.keyCode || event.code, event))) ||
          event.code == 13 || (event.code == 9 && this.options.tabMode != "default") ||
          (event.code == 32 && event.shiftKey && this.options.tabMode == "default"))
        event.stop();
      else if (electric && electric.indexOf(event.character) != -1)
        this.parent.setTimeout(function(){self.indentAtCursor(null);}, 0);
      else if ((event.character == "v" || event.character == "V")
               && (event.ctrlKey || event.metaKey) && !event.altKey) // ctrl-V
        this.reroutePasteEvent();
    },

    // Mark the node at the cursor dirty when a non-safe key is
    // released.
    keyUp: function(event) {
      this.cursorActivity(isSafeKey(event.keyCode));
    },

    // Indent the line following a given <br>, or null for the first
    // line. If given a <br> element, this must have been highlighted
    // so that it has an indentation method. Returns the whitespace
    // element that has been modified or created (if any).
    indentLineAfter: function(start, direction) {
      // whiteSpace is the whitespace span at the start of the line,
      // or null if there is no such node.
      var whiteSpace = start ? start.nextSibling : this.container.firstChild;
      if (whiteSpace && !hasClass(whiteSpace, "whitespace"))
        whiteSpace = null;

      // Sometimes the start of the line can influence the correct
      // indentation, so we retrieve it.
      var firstText = whiteSpace ? whiteSpace.nextSibling : (start ? start.nextSibling : this.container.firstChild);
      var nextChars = (start && firstText && firstText.currentText) ? firstText.currentText : "";

      // Ask the lexical context for the correct indentation, and
      // compute how much this differs from the current indentation.
      var newIndent = 0, curIndent = whiteSpace ? whiteSpace.currentText.length : 0;
      if (direction != null && this.options.tabMode == "shift")
        newIndent = direction ? curIndent + indentUnit : Math.max(0, curIndent - indentUnit)
      else if (start)
        newIndent = start.indentation(nextChars, curIndent, direction);
      else if (Editor.Parser.firstIndentation)
        newIndent = Editor.Parser.firstIndentation(nextChars, curIndent, direction);
      var indentDiff = newIndent - curIndent;

      // If there is too much, this is just a matter of shrinking a span.
      if (indentDiff < 0) {
        if (newIndent == 0) {
          if (firstText) select.snapshotMove(whiteSpace.firstChild, firstText.firstChild, 0);
          removeElement(whiteSpace);
          whiteSpace = null;
        }
        else {
          select.snapshotMove(whiteSpace.firstChild, whiteSpace.firstChild, indentDiff, true);
          whiteSpace.currentText = makeWhiteSpace(newIndent);
          whiteSpace.firstChild.nodeValue = whiteSpace.currentText;
        }
      }
      // Not enough...
      else if (indentDiff > 0) {
        // If there is whitespace, we grow it.
        if (whiteSpace) {
          whiteSpace.currentText = makeWhiteSpace(newIndent);
          whiteSpace.firstChild.nodeValue = whiteSpace.currentText;
          select.snapshotMove(whiteSpace.firstChild, whiteSpace.firstChild, indentDiff, true);
        }
        // Otherwise, we have to add a new whitespace node.
        else {
          whiteSpace = makePartSpan(makeWhiteSpace(newIndent), this.doc);
          whiteSpace.className = "whitespace";
          if (start) insertAfter(whiteSpace, start);
          else this.container.insertBefore(whiteSpace, this.container.firstChild);
          select.snapshotMove(firstText && (firstText.firstChild || firstText),
                              whiteSpace.firstChild, newIndent, false, true);
        }
      }
      if (indentDiff != 0) this.addDirtyNode(start);
    },

    // Re-highlight the selected part of the document.
    highlightAtCursor: function() {
      var pos = select.selectionTopNode(this.container, true);
      var to = select.selectionTopNode(this.container, false);
      if (pos === false || to === false) return false;

      select.markSelection(this.win);
      if (this.highlight(pos, endOfLine(to, this.container), true, 20) === false)
        return false;
      select.selectMarked();
      return true;
    },

    // When tab is pressed with text selected, the whole selection is
    // re-indented, when nothing is selected, the line with the cursor
    // is re-indented.
    handleTab: function(direction) {
      if (this.options.tabMode == "spaces")
        select.insertTabAtCursor(this.win);
      else
        this.reindentSelection(direction);
    },

    // Custom home behaviour that doesn't land the cursor in front of
    // leading whitespace unless pressed twice.
    home: function() {
      var cur = select.selectionTopNode(this.container, true), start = cur;
      if (cur === false || !(!cur || cur.isPart || isBR(cur)) || !this.container.firstChild)
        return false;

      while (cur && !isBR(cur)) cur = cur.previousSibling;
      var next = cur ? cur.nextSibling : this.container.firstChild;
      if (next && next != start && next.isPart && hasClass(next, "whitespace"))
        select.focusAfterNode(next, this.container);
      else
        select.focusAfterNode(cur, this.container);

      select.scrollToCursor(this.container);
      return true;
    },

    // Some browsers (Opera) don't manage to handle the end key
    // properly in the face of vertical scrolling.
    end: function() {
      var cur = select.selectionTopNode(this.container, true);
      if (cur === false) return false;
      cur = endOfLine(cur, this.container);
      if (!cur) return false;
      select.focusAfterNode(cur.previousSibling, this.container);
      select.scrollToCursor(this.container);
      return true;
    },

    pageUp: function() {
      var line = this.cursorPosition().line, scrollAmount = this.visibleLineCount();
      if (line === false || scrollAmount === false) return false;
      // Try to keep one line on the screen.
      scrollAmount -= 2;
      for (var i = 0; i < scrollAmount; i++) {
        line = this.prevLine(line);
        if (line === false) break;
      }
      if (i == 0) return false; // Already at first line
      select.setCursorPos(this.container, {node: line, offset: 0});
      select.scrollToCursor(this.container);
      return true;
    },

    pageDown: function() {
      var line = this.cursorPosition().line, scrollAmount = this.visibleLineCount();
      if (line === false || scrollAmount === false) return false;
      // Try to move to the last line of the current page.
      scrollAmount -= 2;
      for (var i = 0; i < scrollAmount; i++) {
        var nextLine = this.nextLine(line);
        if (nextLine === false) break;
        line = nextLine;
      }
      if (i == 0) return false; // Already at last line
      select.setCursorPos(this.container, {node: line, offset: 0});
      select.scrollToCursor(this.container);
      return true;
    },

    // Delay (or initiate) the next paren highlight event.
    scheduleParenHighlight: function() {
      if (this.parenEvent) this.parent.clearTimeout(this.parenEvent);
      var self = this;
      this.parenEvent = this.parent.setTimeout(function(){self.highlightParens();}, 300);
    },

    // Take the token before the cursor. If it contains a character in
    // '()[]{}', search for the matching paren/brace/bracket, and
    // highlight them in green for a moment, or red if no proper match
    // was found.
    highlightParens: function(jump, fromKey) {
      var self = this;
      // give the relevant nodes a colour.
      function highlight(node, ok) {
        if (!node) return;
        if (self.options.markParen) {
          self.options.markParen(node, ok);
        }
        else {
          node.style.fontWeight = "bold";
          node.style.color = ok ? "#8F8" : "#F88";
        }
      }
      function unhighlight(node) {
        if (!node) return;
        if (self.options.unmarkParen) {
          self.options.unmarkParen(node);
        }
        else {
          node.style.fontWeight = "";
          node.style.color = "";
        }
      }
      if (!fromKey && self.highlighted) {
        unhighlight(self.highlighted[0]);
        unhighlight(self.highlighted[1]);
      }

      if (!window.select) return;
      // Clear the event property.
      if (this.parenEvent) this.parent.clearTimeout(this.parenEvent);
      this.parenEvent = null;

      // Extract a 'paren' from a piece of text.
      function paren(node) {
        if (node.currentText) {
          var match = node.currentText.match(/^[\s\u00a0]*([\(\)\[\]{}])[\s\u00a0]*$/);
          return match && match[1];
        }
      }
      // Determine the direction a paren is facing.
      function forward(ch) {
        return /[\(\[\{]/.test(ch);
      }

      var ch, cursor = select.selectionTopNode(this.container, true);
      if (!cursor || !this.highlightAtCursor()) return;
      cursor = select.selectionTopNode(this.container, true);
      if (!(cursor && ((ch = paren(cursor)) || (cursor = cursor.nextSibling) && (ch = paren(cursor)))))
        return;
      // We only look for tokens with the same className.
      var className = cursor.className, dir = forward(ch), match = matching[ch];

      // Since parts of the document might not have been properly
      // highlighted, and it is hard to know in advance which part we
      // have to scan, we just try, and when we find dirty nodes we
      // abort, parse them, and re-try.
      function tryFindMatch() {
        var stack = [], ch, ok = true;
        for (var runner = cursor; runner; runner = dir ? runner.nextSibling : runner.previousSibling) {
          if (runner.className == className && isSpan(runner) && (ch = paren(runner))) {
            if (forward(ch) == dir)
              stack.push(ch);
            else if (!stack.length)
              ok = false;
            else if (stack.pop() != matching[ch])
              ok = false;
            if (!stack.length) break;
          }
          else if (runner.dirty || !isSpan(runner) && !isBR(runner)) {
            return {node: runner, status: "dirty"};
          }
        }
        return {node: runner, status: runner && ok};
      }

      while (true) {
        var found = tryFindMatch();
        if (found.status == "dirty") {
          this.highlight(found.node, endOfLine(found.node));
          // Needed because in some corner cases a highlight does not
          // reach a node.
          found.node.dirty = false;
          continue;
        }
        else {
          highlight(cursor, found.status);
          highlight(found.node, found.status);
          if (fromKey)
            self.parent.setTimeout(function() {unhighlight(cursor); unhighlight(found.node);}, 500);
          else
            self.highlighted = [cursor, found.node];
          if (jump && found.node)
            select.focusAfterNode(found.node.previousSibling, this.container);
          break;
        }
      }
    },

    // Adjust the amount of whitespace at the start of the line that
    // the cursor is on so that it is indented properly.
    indentAtCursor: function(direction) {
      if (!this.container.firstChild) return;
      // The line has to have up-to-date lexical information, so we
      // highlight it first.
      if (!this.highlightAtCursor()) return;
      var cursor = select.selectionTopNode(this.container, false);
      // If we couldn't determine the place of the cursor,
      // there's nothing to indent.
      if (cursor === false)
        return;
      select.markSelection(this.win);
      this.indentLineAfter(startOfLine(cursor), direction);
      select.selectMarked();
    },

    // Indent all lines whose start falls inside of the current
    // selection.
    indentRegion: function(start, end, direction) {
      var current = (start = startOfLine(start)), before = start && startOfLine(start.previousSibling);
      if (!isBR(end)) end = endOfLine(end, this.container);
      this.addDirtyNode(start);

      do {
        var next = endOfLine(current, this.container);
        if (current) this.highlight(before, next, true);
        this.indentLineAfter(current, direction);
        before = current;
        current = next;
      } while (current != end);
      select.setCursorPos(this.container, {node: start, offset: 0}, {node: end, offset: 0});
    },

    // Find the node that the cursor is in, mark it as dirty, and make
    // sure a highlight pass is scheduled.
    cursorActivity: function(safe) {
      // pagehide event hack above
      if (this.unloaded) {
        this.win.document.designMode = "off";
        this.win.document.designMode = "on";
        this.unloaded = false;
      }

      if (internetExplorer) {
        this.container.createTextRange().execCommand("unlink");
        this.selectionSnapshot = select.getBookmark(this.container);
      }

      var activity = this.options.cursorActivity;
      if (!safe || activity) {
        var cursor = select.selectionTopNode(this.container, false);
        if (cursor === false || !this.container.firstChild) return;
        cursor = cursor || this.container.firstChild;
        if (activity) activity(cursor);
        if (!safe) {
          this.scheduleHighlight();
          this.addDirtyNode(cursor);
        }
      }
    },

    reparseBuffer: function() {
      forEach(this.container.childNodes, function(node) {node.dirty = true;});
      if (this.container.firstChild)
        this.addDirtyNode(this.container.firstChild);
    },

    // Add a node to the set of dirty nodes, if it isn't already in
    // there.
    addDirtyNode: function(node) {
      node = node || this.container.firstChild;
      if (!node) return;

      for (var i = 0; i < this.dirty.length; i++)
        if (this.dirty[i] == node) return;

      if (node.nodeType != 3)
        node.dirty = true;
      this.dirty.push(node);
    },

    allClean: function() {
      return !this.dirty.length;
    },

    // Cause a highlight pass to happen in options.passDelay
    // milliseconds. Clear the existing timeout, if one exists. This
    // way, the passes do not happen while the user is typing, and
    // should as unobtrusive as possible.
    scheduleHighlight: function() {
      // Timeouts are routed through the parent window, because on
      // some browsers designMode windows do not fire timeouts.
      var self = this;
      this.parent.clearTimeout(this.highlightTimeout);
      this.highlightTimeout = this.parent.setTimeout(function(){self.highlightDirty();}, this.options.passDelay);
    },

    // Fetch one dirty node, and remove it from the dirty set.
    getDirtyNode: function() {
      while (this.dirty.length > 0) {
        var found = this.dirty.pop();
        // IE8 sometimes throws an unexplainable 'invalid argument'
        // exception for found.parentNode
        try {
          // If the node has been coloured in the meantime, or is no
          // longer in the document, it should not be returned.
          while (found && found.parentNode != this.container)
            found = found.parentNode;
          if (found && (found.dirty || found.nodeType == 3))
            return found;
        } catch (e) {}
      }
      return null;
    },

    // Pick dirty nodes, and highlight them, until options.passTime
    // milliseconds have gone by. The highlight method will continue
    // to next lines as long as it finds dirty nodes. It returns
    // information about the place where it stopped. If there are
    // dirty nodes left after this function has spent all its lines,
    // it shedules another highlight to finish the job.
    highlightDirty: function(force) {
      // Prevent FF from raising an error when it is firing timeouts
      // on a page that's no longer loaded.
      if (!window.select) return false;

      if (!this.options.readOnly) select.markSelection(this.win);
      var start, endTime = force ? null : time() + this.options.passTime;
      while ((time() < endTime || force) && (start = this.getDirtyNode())) {
        var result = this.highlight(start, endTime);
        if (result && result.node && result.dirty)
          this.addDirtyNode(result.node);
      }
      if (!this.options.readOnly) select.selectMarked();
      if (start) this.scheduleHighlight();
      return this.dirty.length == 0;
    },

    // Creates a function that, when called through a timeout, will
    // continuously re-parse the document.
    documentScanner: function(passTime) {
      var self = this, pos = null;
      return function() {
        // FF timeout weirdness workaround.
        if (!window.select) return;
        // If the current node is no longer in the document... oh
        // well, we start over.
        if (pos && pos.parentNode != self.container)
          pos = null;
        select.markSelection(self.win);
        var result = self.highlight(pos, time() + passTime, true);
        select.selectMarked();
        var newPos = result ? (result.node && result.node.nextSibling) : null;
        pos = (pos == newPos) ? null : newPos;
        self.delayScanning();
      };
    },

    // Starts the continuous scanning process for this document after
    // a given interval.
    delayScanning: function() {
      if (this.scanner) {
        this.parent.clearTimeout(this.documentScan);
        this.documentScan = this.parent.setTimeout(this.scanner, this.options.continuousScanning);
      }
    },

    // The function that does the actual highlighting/colouring (with
    // help from the parser and the DOM normalizer). Its interface is
    // rather overcomplicated, because it is used in different
    // situations: ensuring that a certain line is highlighted, or
    // highlighting up to X milliseconds starting from a certain
    // point. The 'from' argument gives the node at which it should
    // start. If this is null, it will start at the beginning of the
    // document. When a timestamp is given with the 'target' argument,
    // it will stop highlighting at that time. If this argument holds
    // a DOM node, it will highlight until it reaches that node. If at
    // any time it comes across two 'clean' lines (no dirty nodes), it
    // will stop, except when 'cleanLines' is true. maxBacktrack is
    // the maximum number of lines to backtrack to find an existing
    // parser instance. This is used to give up in situations where a
    // highlight would take too long and freeze the browser interface.
    highlight: function(from, target, cleanLines, maxBacktrack){
      var container = this.container, self = this, active = this.options.activeTokens;
      var endTime = (typeof target == "number" ? target : null);

      if (!container.firstChild)
        return false;
      // Backtrack to the first node before from that has a partial
      // parse stored.
      while (from && (!from.parserFromHere || from.dirty)) {
        if (maxBacktrack != null && isBR(from) && (--maxBacktrack) < 0)
          return false;
        from = from.previousSibling;
      }
      // If we are at the end of the document, do nothing.
      if (from && !from.nextSibling)
        return false;

      // Check whether a part (<span> node) and the corresponding token
      // match.
      function correctPart(token, part){
        return !part.reduced && part.currentText == token.value && part.className == token.style;
      }
      // Shorten the text associated with a part by chopping off
      // characters from the front. Note that only the currentText
      // property gets changed. For efficiency reasons, we leave the
      // nodeValue alone -- we set the reduced flag to indicate that
      // this part must be replaced.
      function shortenPart(part, minus){
        part.currentText = part.currentText.substring(minus);
        part.reduced = true;
      }
      // Create a part corresponding to a given token.
      function tokenPart(token){
        var part = makePartSpan(token.value, self.doc);     
        part.className = token.style;
        return part;
      }

      function maybeTouch(node) {
        if (node) {
          var old = node.oldNextSibling;
          if (lineDirty || old === undefined || node.nextSibling != old)
            self.history.touch(node);
          node.oldNextSibling = node.nextSibling;
        }
        else {
          var old = self.container.oldFirstChild;
          if (lineDirty || old === undefined || self.container.firstChild != old)
            self.history.touch(null);
          self.container.oldFirstChild = self.container.firstChild;
        }
      }

      // Get the token stream. If from is null, we start with a new
      // parser from the start of the frame, otherwise a partial parse
      // is resumed.
      var traversal = traverseDOM(from ? from.nextSibling : container.firstChild),
          stream = stringStream(traversal),
          parsed = from ? from.parserFromHere(stream) : Editor.Parser.make(stream);

      function surroundedByBRs(node) {
        return (node.previousSibling == null || isBR(node.previousSibling)) &&
               (node.nextSibling == null || isBR(node.nextSibling));
      }

      // parts is an interface to make it possible to 'delay' fetching
      // the next DOM node until we are completely done with the one
      // before it. This is necessary because often the next node is
      // not yet available when we want to proceed past the current
      // one.
      var parts = {
        current: null,
        // Fetch current node.
        get: function(){
          if (!this.current)
            this.current = traversal.nodes.shift();
          return this.current;
        },
        // Advance to the next part (do not fetch it yet).
        next: function(){
          this.current = null;
        },
        // Remove the current part from the DOM tree, and move to the
        // next.
        remove: function(){
          container.removeChild(this.get());
          this.current = null;
        },
        // Advance to the next part that is not empty, discarding empty
        // parts.
        getNonEmpty: function(){
          var part = this.get();
          // Allow empty nodes when they are alone on a line, needed
          // for the FF cursor bug workaround (see select.js,
          // insertNewlineAtCursor).
          while (part && isSpan(part) && part.currentText == "") {
            // Leave empty nodes that are alone on a line alone in
            // Opera, since that browsers doesn't deal well with
            // having 2 BRs in a row.
            if (window.opera && surroundedByBRs(part)) {
              this.next();
              part = this.get();
            }
            else {
              var old = part;
              this.remove();
              part = this.get();
              // Adjust selection information, if any. See select.js for details.
              select.snapshotMove(old.firstChild, part && (part.firstChild || part), 0);
            }
          }
          
          return part;
        }
      };

      var lineDirty = false, prevLineDirty = true, lineNodes = 0;

      // This forEach loops over the tokens from the parsed stream, and
      // at the same time uses the parts object to proceed through the
      // corresponding DOM nodes.
      forEach(parsed, function(token){
        var part = parts.getNonEmpty();

        if (token.value == "\n"){
          // The idea of the two streams actually staying synchronized
          // is such a long shot that we explicitly check.
          if (!isBR(part))
            throw "Parser out of sync. Expected BR.";

          if (part.dirty || !part.indentation) lineDirty = true;
          maybeTouch(from);
          from = part;

          // Every <br> gets a copy of the parser state and a lexical
          // context assigned to it. The first is used to be able to
          // later resume parsing from this point, the second is used
          // for indentation.
          part.parserFromHere = parsed.copy();
          part.indentation = token.indentation;
          part.dirty = false;

          // If the target argument wasn't an integer, go at least
          // until that node.
          if (endTime == null && part == target) throw StopIteration;

          // A clean line with more than one node means we are done.
          // Throwing a StopIteration is the way to break out of a
          // MochiKit forEach loop.
          if ((endTime != null && time() >= endTime) || (!lineDirty && !prevLineDirty && lineNodes > 1 && !cleanLines))
            throw StopIteration;
          prevLineDirty = lineDirty; lineDirty = false; lineNodes = 0;
          parts.next();
        }
        else {
          if (!isSpan(part))
            throw "Parser out of sync. Expected SPAN.";
          if (part.dirty)
            lineDirty = true;
          lineNodes++;

          // If the part matches the token, we can leave it alone.
          if (correctPart(token, part)){
            part.dirty = false;
            parts.next();
          }
          // Otherwise, we have to fix it.
          else {
            lineDirty = true;
            // Insert the correct part.
            var newPart = tokenPart(token);
            container.insertBefore(newPart, part);
            if (active) active(newPart, token, self);
            var tokensize = token.value.length;
            var offset = 0;
            // Eat up parts until the text for this token has been
            // removed, adjusting the stored selection info (see
            // select.js) in the process.
            while (tokensize > 0) {
              part = parts.get();
              var partsize = part.currentText.length;
              select.snapshotReplaceNode(part.firstChild, newPart.firstChild, tokensize, offset);
              if (partsize > tokensize){
                shortenPart(part, tokensize);
                tokensize = 0;
              }
              else {
                tokensize -= partsize;
                offset += partsize;
                parts.remove();
              }
            }
          }
        }
      });
      maybeTouch(from);
      webkitLastLineHack(this.container);

      // The function returns some status information that is used by
      // hightlightDirty to determine whether and where it has to
      // continue.
      return {node: parts.getNonEmpty(),
              dirty: lineDirty};
    }
  };

  return Editor;
})();

addEventHandler(window, "load", function() {
  var CodeMirror = window.frameElement.CodeMirror;
  var e = CodeMirror.editor = new Editor(CodeMirror.options);
  this.parent.setTimeout(method(CodeMirror, "init"), 0);
});
