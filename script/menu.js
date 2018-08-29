 function flipNav()
  {
  	//alert(document.getElementById("mySidenav").style.width);
  	if (document.getElementById("mySidenav").style.width == "200px")
  	{
  	  document.getElementById("mySidenav").style.width = "50px";
      document.getElementById("main").style.marginLeft= "30px";
      document.body.style.backgroundColor = "white";
      document.getElementById('xact').innerHTML = "<div style='height: 34px;'><span><img src='img/xact.png' style='height: 28px; width: 28px;'></span></div>";
      document.getElementById('client').innerHTML = "<div style='height: 34px;'><span><img src='img/client.png' style='height: 28px; width: 28px;'></span></div>";
      document.getElementById('item').innerHTML = "<div style='height: 34px;'><span><img src='img/item.png' style='height: 28px; width: 28px;'></span></div>";
      document.getElementById('settings').innerHTML = "<div style='height: 34px;'><span><img src='img/settings.png' style='height: 28px; width: 28px;'></span></div>";
      document.getElementById('reports').innerHTML = "<div style='height: 34px;'><span><img src='img/reports.png' style='height: 28px; width: 28px;'></span></div>";
  	}
  	else
  	{
  		document.getElementById("mySidenav").style.width = "200px";
    	document.getElementById("main").style.marginLeft = "180px";
   	 	document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    	document.getElementById('xact').innerHTML = "<div style='height: 34px;'><span><img src='img/xact.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Transaction</span></div>";
    	document.getElementById('client').innerHTML = "<div style='height: 34px;'><span><img src='img/client.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Client</span></div>";
    	document.getElementById('item').innerHTML = "<div style='height: 34px;'><span><img src='img/item.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Item</span></div>";
    	document.getElementById('settings').innerHTML = "<div style='height: 34px;'><span><img src='img/settings.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Settings</span></div>";
    	document.getElementById('reports').innerHTML = "<div style='height: 34px;'><span><img src='img/reports.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Reports</span></div>";
  	}
  }