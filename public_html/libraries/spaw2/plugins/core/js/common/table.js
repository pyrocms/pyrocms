// table functions

SpawPGcore.tableCreateClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    SpawEngine.openDialog('core', 'table_prop', editor, null, '', 'SpawPGcore.tableCreateClickCallback', tbi, sender);
  }
}

SpawPGcore.tableCreateClickCallback = function(editor, result, tbi, sender)
{
  if (result)
  {
    editor.insertNodeAtSelection(result);
  }
  editor.updateToolbar();
  editor.focus();
}

SpawPGcore.tablePropClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var tbl = editor.getSelectedElementByTagName("table");
    
    SpawEngine.openDialog('core', 'table_prop', editor, tbl, '', 'SpawPGcore.tablePropClickCallback', tbi, sender);
  }
}

SpawPGcore.tablePropClickCallback = function(editor, result, tbi, sender)
{
  var tbl = editor.getSelectedElementByTagName("table");

  if (!tbl && result)
  {
    editor.insertNodeAtSelection(result);
  }
  editor.updateToolbar();
  editor.focus();
}
SpawPGcore.isTablePropertiesEnabled = function(editor, tbi)
{
  if (editor.isInDesignMode())
  {
    var tbl = editor.getSelectedElementByTagName("table");
    
    return (tbl)?true:false;
  }
  else
  {
    return false;
  }
}

SpawPGcore.tableCellPropClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var tc = editor.getSelectedElementByTagName("td");
    if (tc == null)
      tc =  editor.getSelectedElementByTagName("th");
    
    SpawEngine.openDialog('core', 'table_cell_prop', editor, tc, '', '', tbi, sender);
  }
}

SpawPGcore.isTableCellPropertiesEnabled = function(editor, tbi)
{
  if (editor.isInDesignMode())
  {
    var tbl = editor.getSelectedElementByTagName("td");
    if (!tbl)
      tbl = editor.getSelectedElementByTagName("th");
    
    return (tbl)?true:false;
  }
  else
  {
    return false;
  }
}


// returns cell matrix for the table
SpawPGcore.tableCellMatrix = function(tbl)
{
  var tm = new Array();
  var rows;
  if (tbl.rows && tbl.rows.length>0)
  {
    // ie, opera
    rows = tbl.rows;
  }
  else
  {
    // gecko
    rows = tbl.getElementsByTagName("TR");
  }
  for (var i=0; i<rows.length; i++)
    tm[i]=new Array();

  for (var i=0; i<rows.length; i++)
  {
    jr=0;
    for (var j=0; j<rows[i].cells.length;j++)
    {
      while (tm[i][jr] != undefined) 
        jr++;

      for (var jh=jr; jh<jr+(rows[i].cells[j].colSpan?rows[i].cells[j].colSpan:1);jh++)
      {
        for (var jv=i; jv<i+(rows[i].cells[j].rowSpan?rows[i].cells[j].rowSpan:1);jv++)
        {
          if (jv==i)
          {
            tm[jv][jh]=rows[i].cells[j].cellIndex;
          }
          else
          {
            tm[jv][jh]=-1;
          }
        }
      }
    }
  }
  return(tm);
}

SpawPGcore.insertTableRowClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var tbl = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
  
    if (tbl && cr)
    {
      var newr = tbl.insertRow(cr.rowIndex+1);
      for (var i=0; i<cr.cells.length; i++)
      {
        if (cr.cells[i].rowSpan > 1)
        {
          // increase rowspan
          cr.cells[i].rowSpan++;
        }
        else
        {
          var newc = cr.cells[i].cloneNode(false);
          newc.innerHTML = "&nbsp;"; // workaround for gecko and opera
          newr.appendChild(newc);
        }
      }
      // increase rowspan for cells that were spanning through current row
      for (var i=0; i<cr.rowIndex; i++)
      {
        var tempr; 
        if (tbl.rows && tbl.rows.length > 0)
        {
          // ie, opera
          tempr = tbl.rows[i];
        }
        else
        {
          // gecko
          tempr = tbl.getElementsByTagName("tr")[i];
        }
        for (var j=0; j<tempr.cells.length; j++)
        {
          if (tempr.cells[j].rowSpan > (cr.rowIndex - i))
            tempr.cells[j].rowSpan++;
        }
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
}

SpawPGcore.insertTableColumnClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var ct = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
    var cd = editor.getSelectedElementByTagName("td"); // current cell
  
    if (cd && cr && ct)
    {
      // get "real" cell position and form cell matrix
      var tm = SpawPGcore.tableCellMatrix(ct);
  
      var rows;
      if (ct.rows && ct.rows.length>0)
      {
        // ie, opera
        rows = ct.rows;
      }
      else
      {
        // gecko
        rows = ct.getElementsByTagName("TR");
      }
      var rowIndex;
      if (cr.rowIndex >=0)
      {
        // ie, opera
        rowIndex = cr.rowIndex;
      }
      else
      {
        // gecko
        for(var ri=0; ri<rows.length; ri++)
        {
          if (rows[ri] == cr)
          {
            rowIndex = ri;
            break;
          }
        }
      }
      
      var realIndex;
  
      for (var j=0; j<tm[rowIndex].length; j++)
      {
        if (tm[rowIndex][j] == cd.cellIndex)
        {
          realIndex=j;
          break;
        }
      }
  
      // insert column based on real cell matrix
      for (var i=0; i<rows.length; i++)
      {
        if (tm[i][realIndex] != -1)
        {
          if (rows[i].cells[tm[i][realIndex]].colSpan > 1)
          {
            rows[i].cells[tm[i][realIndex]].colSpan++;
          }
          else
          {
            var newc = rows[i].insertCell(tm[i][realIndex]+1);
            var nc = rows[i].cells[tm[i][realIndex]].cloneNode(false);
            nc.innerHTML = "&nbsp;";
            rows[i].replaceChild(nc, newc);
          }
        }
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
} // insert column

SpawPGcore.mergeTableCellRightClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var ct = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
    var cd = editor.getSelectedElementByTagName("td"); // current cell
  
    if (cd && cr && ct)
    {
      // get "real" cell position and form cell matrix
      var tm = SpawPGcore.tableCellMatrix(ct);
  
      var rows;
      if (ct.rows && ct.rows.length>0)
      {
        // ie, opera
        rows = ct.rows;
      }
      else
      {
        // gecko
        rows = ct.getElementsByTagName("TR");
      }
      var rowIndex;
      if (cr.rowIndex >=0)
      {
        // ie, opera
        rowIndex = cr.rowIndex;
      }
      else
      {
        // gecko
        for(var ri=0; ri<rows.length; ri++)
        {
          if (rows[ri] == cr)
          {
            rowIndex = ri;
            break;
          }
        }
      }
  
      var realIndex;
          
      for (var j=0; j<tm[rowIndex].length; j++)
      {
        if (tm[rowIndex][j] == cd.cellIndex)
        {
          realIndex=j;
          break;
        }
      }
      
      if (cd.cellIndex+1<cr.cells.length)
      {
        var ccrs = cd.rowSpan?cd.rowSpan:1;
        var cccs = cd.colSpan?cd.colSpan:1;
        var ncrs = cr.cells[cd.cellIndex+1].rowSpan?cr.cells[cd.cellIndex+1].rowSpan:1;
        var nccs = cr.cells[cd.cellIndex+1].colSpan?cr.cells[cd.cellIndex+1].colSpan:1;
        // check if theres nothing between these 2 cells
        var j=realIndex;
        while(tm[rowIndex][j] == cd.cellIndex) j++;
        if (tm[rowIndex][j] == cd.cellIndex+1)
        {
          // proceed only if current and next cell rowspans are equal
          if (ccrs == ncrs)
          {
            // increase colspan of current cell and append content of the next cell to current
            cd.colSpan = cccs+nccs;
            cd.innerHTML += cr.cells[cd.cellIndex+1].innerHTML;
            cr.deleteCell(cd.cellIndex+1);
          }
        }
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
} // merge right

SpawPGcore.mergeTableCellDownClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var ct = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
    var cd = editor.getSelectedElementByTagName("td"); // current cell
  
    if (cd && cr && ct)
    {
      // get "real" cell position and form cell matrix
      var tm = SpawPGcore.tableCellMatrix(ct);
  
      var rows;
      if (ct.rows && ct.rows.length>0)
      {
        // ie, opera
        rows = ct.rows;
      }
      else
      {
        // gecko
        rows = ct.getElementsByTagName("TR");
      }
      var rowIndex;
      if (cr.rowIndex >=0)
      {
        // ie, opera
        rowIndex = cr.rowIndex;
      }
      else
      {
        // gecko
        for(var ri=0; ri<rows.length; ri++)
        {
          if (rows[ri] == cr)
          {
            rowIndex = ri;
            break;
          }
        }
      }
  
      var crealIndex;
      
      for (var j=0; j<tm[rowIndex].length; j++)
      {
        if (tm[rowIndex][j] == cd.cellIndex)
        {
          crealIndex=j;
          break;
        }
      }
      var ccrs = cd.rowSpan?cd.rowSpan:1;
      var cccs = cd.colSpan?cd.colSpan:1;
      if (rowIndex+ccrs<rows.length)
      {
        var ncellIndex = tm[rowIndex+ccrs][crealIndex];
        if (ncellIndex != -1 && (crealIndex==0 || (crealIndex>0 && (tm[rowIndex+ccrs][crealIndex-1]!=tm[rowIndex+ccrs][crealIndex]))))
        {
    
          var ncrs = rows[rowIndex+ccrs].cells[ncellIndex].rowSpan?rows[rowIndex+ccrs].cells[ncellIndex].rowSpan:1;
          var nccs = rows[rowIndex+ccrs].cells[ncellIndex].colSpan?rows[rowIndex+ccrs].cells[ncellIndex].colSpan:1;
          // proceed only if current and next cell colspans are equal
          if (cccs == nccs)
          {
            // increase rowspan of current cell and append content of the next cell to current
            cd.innerHTML += rows[rowIndex+ccrs].cells[ncellIndex].innerHTML;
            rows[rowIndex+ccrs].deleteCell(ncellIndex);
            cd.rowSpan = ccrs+ncrs;
          }
        }
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
} // merge down

SpawPGcore.deleteTableRowClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var ct = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
    var cd = editor.getSelectedElementByTagName("td"); // current cell
  
  
    if (cd && cr && ct)
    {
      // get "real" cell position and form cell matrix
      var tm = SpawPGcore.tableCellMatrix(ct);
  
      var rows;
      if (ct.rows && ct.rows.length>0)
      {
        // ie, opera
        rows = ct.rows;
      }
      else
      {
        // gecko
        rows = ct.getElementsByTagName("TR");
      }
      var rowIndex;
      if (cr.rowIndex >=0)
      {
        // ie, opera
        rowIndex = cr.rowIndex;
      }
      else
      {
        // gecko
        for(var ri=0; ri<rows.length; ri++)
        {
          if (rows[ri] == cr)
          {
            rowIndex = ri;
            break;
          }
        }
      }
  
      // if there's only one row just remove the table
      if (rows.length<=1)
      {
        ct.parentNode.removeChild(ct);
      }
      else
      {
        // decrease rowspan for cells that were spanning through current row
        for (var i=0; i<rowIndex; i++)
        {
          var tempr = rows[i];
          for (var j=0; j<tempr.cells.length; j++)
          {
            if (tempr.cells[j].rowSpan > (rowIndex - i))
              tempr.cells[j].rowSpan--;
          }
        }
    
        
        var curCI = -1;
        // check for current row cells spanning more than 1 row
        for (var i=0; i<tm[rowIndex].length; i++)
        {
          var prevCI = curCI;
          curCI = tm[rowIndex][i];
          if (curCI != -1 && curCI != prevCI && cr.cells[curCI].rowSpan>1 && (rowIndex+1)<rows.length)
          {
            var ni = i;
            var nrCI = tm[rowIndex+1][ni];
            while (nrCI == -1) 
            {
              ni++;
              if (ni<rows[rowIndex+1].cells.length)
                nrCI = tm[rowIndex+1][ni];
              else
                nrCI = rows[rowIndex+1].cells.length;
            }
            
            var newc = rows[rowIndex+1].insertCell(nrCI);
            rows[rowIndex].cells[curCI].rowSpan--;
            var nc = rows[rowIndex].cells[curCI].cloneNode(false);
            rows[rowIndex+1].replaceChild(nc, newc);
            // fix the matrix
            var cs = (cr.cells[curCI].colSpan>1)?cr.cells[curCI].colSpan:1;
            var nj;
            for (var j=i; j<(i+cs);j++)
            {
              tm[rowIndex+1][j] = nrCI;
              nj = j;
            }
            for (var j=nj; j<tm[rowIndex+1].length; j++)
            {
              if (tm[rowIndex+1][j] != -1)
                tm[rowIndex+1][j]++;
            }
          }
        }
        // delete row
        if (ct.rows && ct.rows.length > 0)
        {
          // ie, opera
          ct.deleteRow(rowIndex);
        }
        else
        {
          // gecko
          ct.removeChild(rows[rowIndex]);
        }
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
} // delete row

SpawPGcore.deleteTableColumnClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var ct = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
    var cd = editor.getSelectedElementByTagName("td"); // current cell
  
    if (cd && cr && ct)
    {
      // get "real" cell position and form cell matrix
      var tm = SpawPGcore.tableCellMatrix(ct);
  
      var rows;
      if (ct.rows && ct.rows.length>0)
      {
        // ie, opera
        rows = ct.rows;
      }
      else
      {
        // gecko
        rows = ct.getElementsByTagName("TR");
      }
      var rowIndex;
      if (cr.rowIndex >=0)
      {
        // ie, opera
        rowIndex = cr.rowIndex;
      }
      else
      {
        // gecko
        for(var ri=0; ri<rows.length; ri++)
        {
          if (rows[ri] == cr)
          {
            rowIndex = ri;
            break;
          }
        }
      }
  
      var realIndex;
      // if there's only one column delete the table
      if (tm[0].length<=1)  
      {
        ct.parentNode.removeChild(ct);
      }
      else
      {
        for (var j=0; j<tm[rowIndex].length; j++)
        {
          if (tm[rowIndex][j] == cd.cellIndex)
          {
            realIndex=j;
            break;
          }
        }
        
        for (var i=0; i<rows.length; i++)
        {
          if (tm[i][realIndex] != -1)
          {
            if (rows[i].cells[tm[i][realIndex]].colSpan>1)
              rows[i].cells[tm[i][realIndex]].colSpan--;
            else
              rows[i].deleteCell(tm[i][realIndex]);
          }
        }
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
} // delete column

SpawPGcore.splitTableCellVerticallyClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var ct = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
    var cd = editor.getSelectedElementByTagName("td"); // current cell
  
    if (cd && cr && ct)
    {
      // get "real" cell position and form cell matrix
      var tm = SpawPGcore.tableCellMatrix(ct);
  
      var rows;
      if (ct.rows && ct.rows.length>0)
      {
        // ie, opera
        rows = ct.rows;
      }
      else
      {
        // gecko
        rows = ct.getElementsByTagName("TR");
      }
      var rowIndex;
      if (cr.rowIndex >=0)
      {
        // ie, opera
        rowIndex = cr.rowIndex;
      }
      else
      {
        // gecko
        for(var ri=0; ri<rows.length; ri++)
        {
          if (rows[ri] == cr)
          {
            rowIndex = ri;
            break;
          }
        }
      }
  
      var realIndex;
      
      for (var j=0; j<tm[rowIndex].length; j++)
      {
        if (tm[rowIndex][j] == cd.cellIndex)
        {
          realIndex=j;
          break;
        }
      }
      
      if (cd.colSpan>1)    
      {
        // split only current cell
        var newc = rows[rowIndex].insertCell(cd.cellIndex+1);
        cd.colSpan--;
        var nc = cd.cloneNode(false);
        nc.innerHTML = "&nbsp;";
        rows[rowIndex].replaceChild(nc, newc);
        cd.colSpan = 1;
      }
      else
      {
        // clone current cell
        var newc = rows[rowIndex].insertCell(cd.cellIndex+1);
        var nc = cd.cloneNode(false);
        nc.innerHTML = "&nbsp;";
        rows[rowIndex].replaceChild(nc, newc);
        
        var cs;
        for (var i=0; i<tm.length; i++)
        {
          if (i!=rowIndex && tm[i][realIndex] != -1)
          {
            cs = rows[i].cells[tm[i][realIndex]].colSpan>1?rows[i].cells[tm[i][realIndex]].colSpan:1;
            rows[i].cells[tm[i][realIndex]].colSpan = cs+1;
          }
        }
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
} // vertical split

SpawPGcore.splitTableCellHorizontallyClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var ct = editor.getSelectedElementByTagName("table");
    var cr = editor.getSelectedElementByTagName("tr"); // current row
    var cd = editor.getSelectedElementByTagName("td"); // current cell
  
    if (cd && cr && ct)
    {
      // get "real" cell position and form cell matrix
      var tm = SpawPGcore.tableCellMatrix(ct);
  
      var rows;
      if (ct.rows && ct.rows.length>0)
      {
        // ie, opera
        rows = ct.rows;
      }
      else
      {
        // gecko
        rows = ct.getElementsByTagName("TR");
      }
      var rowIndex;
      if (cr.rowIndex >=0)
      {
        // ie, opera
        rowIndex = cr.rowIndex;
      }
      else
      {
        // gecko
        for(var ri=0; ri<rows.length; ri++)
        {
          if (rows[ri] == cr)
          {
            rowIndex = ri;
            break;
          }
        }
      }
  
      var realIndex;
  
      for (var j=0; j<tm[rowIndex].length; j++)
      {
        if (tm[rowIndex][j] == cd.cellIndex)
        {
          realIndex=j;
          break;
        }
      }
      
      if (cd.rowSpan>1) 
      {
        // split only current cell
        // find where to insert a cell in the next row
        var i = realIndex;
        var ni;
        while (tm[rowIndex+1][i] == -1) i++;
        if (i == tm[rowIndex+1].length) 
          ni = rows[rowIndex+1].cells.length;
        else
          ni = tm[rowIndex+1][i];
  
        var newc = rows[rowIndex+1].insertCell(ni);
        cd.rowSpan--;
        var nc = cd.cloneNode(false);
        nc.innerHTML = "&nbsp;";
        rows[rowIndex+1].replaceChild(nc, newc);
  
        cd.rowSpan = 1;
      }
      else
      {
        // add new row and make all other cells to span one row more
        if (ct.rows && ct.rows.length > 0)
        {
          // ie, opera
          ct.insertRow(rowIndex+1);
        }
        else
        {
          // gecko
          var pdoc = editor.getActivePageDoc();
          if (rowIndex<(rows.length-1))
          {
            ct.insertBefore(pdoc.createElement("TR"), rows[rowIndex+1]);
          }
          else
          {
            ct.appendChild(pdoc.createElement("TR"));
          }
        }
  
        var rs;
        for (var i=0; i<cr.cells.length; i++)
        {
          if (i != cd.cellIndex)
          {
            rs = cr.cells[i].rowSpan>1?cr.cells[i].rowSpan:1;
            cr.cells[i].rowSpan = rs+1;
          }
        }
  
        for (var i=0; i<rowIndex; i++)
        {
          var tempr = rows[i];
          for (var j=0; j<tempr.cells.length; j++)
          {
            if (tempr.cells[j].rowSpan > (rowIndex - i))
              tempr.cells[j].rowSpan++;
          }
        }
        
        // clone current cell to new row
        var newc = rows[rowIndex+1].insertCell(0);
        var nc = cd.cloneNode(false);
        nc.innerHTML = "&nbsp;";
        rows[rowIndex+1].replaceChild(nc, newc);
      }
    }
    editor.updateToolbar();
    editor.focus();
  }
} // horizontal split
