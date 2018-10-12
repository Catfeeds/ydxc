function setSelect(formName, selectName, value)
{
  var options = document.forms[formName].elements[selectName].options;
  for(i = 0; i < options.length; i ++)
    if(options[i].value == value)
    {
      options.selectedIndex = i;
      break;
    }
}

//设置下拉框的复选，以逗号分隔各值
function setSelectMultiple(formName, selectName, value)
{
  value = "," + value + ",";
  var options = document.forms[formName].elements[selectName].options;
  for(i = 0; i < options.length; i ++) {
	
	val = "," + options[i].value + ",";
    if (value.indexOf(val) != -1) {
      options[i].selected = true;
    }
  
  }
}
