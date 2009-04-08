// Tab class
function SpawTab(page)
{
  this.page = page;
}
SpawTab.prototype.page;
SpawTab.prototype.template;
SpawTab.prototype.active_template;
SpawTab.prototype.setInactive = function()
{
  var tab = document.getElementById(this.page.name + '_tab');
  if (tab)
  {
    tab.innerHTML = this.template;
  }
}
SpawTab.prototype.setActive = function()
{
  var tab = document.getElementById(this.page.name + '_tab');
  if (tab)
  {
    tab.innerHTML = this.active_template;
  }
}
