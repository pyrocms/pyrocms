// event handling
// array storing event handlers
SpawEngine.event_handlers = new Array();
SpawEngine.addEventHandler = function(evt_type, handler_fn, evt_target)
{
  var trg = (evt_target == null)?"page_doc":evt_target.toLowerCase();
  if (!SpawEngine.event_handlers[trg])
    SpawEngine.event_handlers[trg] = new Array();
  if (SpawEngine.event_handlers[trg][evt_type])
  {
    // this is not the first handler for this event
    SpawEngine.event_handlers[trg][evt_type].push(handler_fn);
  }
  else
  {
    // there are no handlers for this event
    if (evt_type.toLowerCase().substring(0,4) != "spaw")
    {
      // non-spaw event, register handlers
      var ev_obj;
      if (trg.substring(0,4) != "page" && trg != "form")
      {
        // not page or editor level events
        ev_obj = SpawEngine.getEventTargetObject(trg, null);
        if (ev_obj.attachEvent)
        {
          // ie
          ev_obj.attachEvent("on"+evt_type, new Function("event", 'SpawEngine.handleEvent("'+evt_type+'", event, "'+trg+'", null);'));
        }
        else
        {
          ev_obj.addEventListener(evt_type, new Function("event", 'SpawEngine.handleEvent("'+evt_type+'", event, "'+trg+'", null);'), false);
        }
      }
      else
      {
        var old_ev_obj;
        for (var si=0; si<SpawEngine.editors.length; si++)
        {
          if (trg == "form")
          {
            // editor level event
            ev_obj = SpawEngine.getEventTargetObject(trg, null, SpawEngine.editors[si]);
            if (ev_obj != old_ev_obj)
            {
              if (ev_obj.attachEvent)
              {
                // ie
                ev_obj.attachEvent("on"+evt_type, new Function("event", 'SpawEngine.handleEvent("'+evt_type+'", event, "'+trg+'","'+SpawEngine.editors[si].name+'");'));
              }
              else
              {
                ev_obj.addEventListener(evt_type, new Function("event", 'SpawEngine.handleEvent("'+evt_type+'", event, "'+trg+'","'+SpawEngine.editors[si].name+'");'), false);
              }
              old_ev_obj = ev_obj;
            }
          }
          else
          {
            // page level event
            for(var i=0; i<SpawEngine.editors[si].pages.length; i++)
            {
              ev_obj = SpawEngine.getEventTargetObject(trg, SpawEngine.editors[si].pages[i], SpawEngine.editors[si]);
              if (ev_obj.attachEvent)
              {
                // ie
                ev_obj.attachEvent("on"+evt_type, new Function("event", 'SpawEngine.handleEvent("'+evt_type+'", event, "'+trg+'","'+SpawEngine.editors[si].name+'");'));
              }
              else
              {
                ev_obj.addEventListener(evt_type, new Function("event", 'SpawEngine.handleEvent("'+evt_type+'", event, "'+trg+'","'+SpawEngine.editors[si].name+'");'), false);
              }
            }
          }
        }
      }
    }
    SpawEngine.event_handlers[trg][evt_type] = new Array();
    SpawEngine.event_handlers[trg][evt_type].push(handler_fn);
  }
}
SpawEngine.handleEvent = function(evt_type, evt, evt_target, editor_name)
{
  var trg = (evt_target == null)?"page_doc":evt_target.toLowerCase();
  var ed = editor_name?SpawEngine.getEditor(editor_name):SpawEngine.getActiveEditor();
  if (SpawEngine.event_handlers[trg] && SpawEngine.event_handlers[trg][evt_type])
  {
    for(var i=0; i<SpawEngine.event_handlers[trg][evt_type].length; i++)
    {
      eval(SpawEngine.event_handlers[trg][evt_type][i] + '(ed, evt)');
    }
  }
}
SpawEngine.getEventTargetObject = function(evt_target, page, editor)
{
  var trg = (evt_target == null)?"page_doc":evt_target.toLowerCase();
  var ev_obj;
  switch(trg)
  {
    case "page_iframe":
      ev_obj = editor.getPageIframeObject(page.name);
      break;
    case "page_doc":
      ev_obj = editor.getPageDoc(page.name);
      break;
    case "page_body":
      ev_obj = editor.getPageDoc(page.name).body;
      break;
    case "form":
      ev_obj = editor.getPageInput(editor.getActivePage().name).form;
      break;
    case "window":
      ev_obj = window;
      break;
    case "document":
      ev_obj = document;
      break;
    default:
      ev_obj = editor.getActivePageDoc();
      break;
  }
  return ev_obj;
}
