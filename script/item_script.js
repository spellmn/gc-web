function fillPage() 
{
  document.getElementById("manufacturer").selectedIndex = 117;
  document.getElementById("model").value = 'Legion 226';
  document.getElementById("serialNumber").value = 'SIG12345';
  document.getElementById("caliber").selectedIndex = 4;
  document.getElementById("general").selectedIndex = 1;
  document.getElementById("barrel").value = 4.8;
  document.getElementById("frame").selectedIndex = 1;
}
//fillPage();	
function emptyPage() 
{
  document.getElementById("manufacturer").selectedIndex = 0;
  document.getElementById("model").value = '';
  document.getElementById("serialNumber").value = '';
  document.getElementById("caliber").selectedIndex = 0;
  document.getElementById("general").selectedIndex = 0;
  document.getElementById("barrel").value = '';
  document.getElementById("frame").selectedIndex = 0;
}

function generalChange(selectObj) 
{
  const handgun = 1;
  const longgun = 2;
  const other = 3;

  var idx = selectObj.selectedIndex; 
  var which = selectObj.options[idx].value; 

  if (which == "REVOLVER" || which == "PISTOL" || which == "C&R PISTOL")
    document.getElementById("frame").selectedIndex = handgun; 
  else if (which == "RECEIVER" || which == "SILENCER")
    document.getElementById("frame").selectedIndex = other; 
  else
    document.getElementById("frame").selectedIndex = longgun; 
}
