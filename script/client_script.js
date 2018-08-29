var isIE8 = window.XDomainRequest ? true : false;
var invocation = createCrossDomainRequest();

function validateAddress()
{
    var authId = '16806553833229898'; // ddns
    //var authId = '16806555066701489'; // Local
    url = 'https://us-street.api.smartystreets.com/street-address?auth-id=' + authId + '&street=';
    url = url + document.getElementById("street3").value.replace(/ /g, '+');
    //alert(url);
    callOtherDomain();
}

function createCrossDomainRequest(url, handler) {
    var request;
    if (isIE8) {
        request = new window.XDomainRequest();
    }
    else {
        request = new XMLHttpRequest();
    }
    return request;
}


 function callOtherDomain() {
    if (invocation) {
        if(isIE8) {
          invocation.onload = outputResult;
          invocation.open("GET", url, true);
          invocation.send();
        }
        else 
        {
            invocation.open('GET', url, true);
            //invocation.responseType = 'json';
            invocation.onreadystatechange = handler;
            invocation.send();
        }
      }
    else 
    {
        var text = "No Invocation TookPlace At All";
        var textNode = document.createTextNode(text);
        var textDiv = document.getElementById("textDiv");
        textDiv.appendChild(textNode);
    }
}

function handler(evtXHR) 
{
    if (invocation.readyState == 4)
    {
        if (invocation.status == 200) 
        {
            outputResult();
        }
        else 
        {
            alert("Invocation Errors Occured: Status " + invocation.status);
        }
    }
}

function outputResult() {
    var response = invocation.responseText;
//    alert(response);
    response = response.substring(1, response.length-1);
//    alert(response);
    if (response == "")
    {
        alert("No matching address found.");
	return false;
    }   
    var myObj = JSON.parse(response);
//    alert(myObj.last_line);
//    alert(myObj.components.primary_number);

    var primary_number = myObj.components.primary_number;
    var street_name =    myObj.components.street_name;
    var street_suffix = myObj.components.street_suffix;
    var city_name = myObj.components.city_name;
    var state_abbreviation = myObj.components.state_abbreviation;
    var zipcode = myObj.components.zipcode;
    var plus4_code = myObj.components.plus4_code;
    var street1 = primary_number + ' ' + street_name + ' ' + street_suffix;
    if (plus4_code)
        zipcode = zipcode + '-' + plus4_code;

    var result = confirm("Accept this addess?\n\n" + street1 + '\n' + city_name + '\n' + state_abbreviation + '\n' + zipcode);
    if (result) {
        document.getElementById("street1").value = street1;
//      document.getElementById("street2").value = street2;
        document.getElementById("city").value = city_name;
        document.getElementById("state").value = state_abbreviation;
        document.getElementById("zip").value = zipcode;
    }
}

function fillPage() 
{
    document.getElementById("firstName").value = 'Michael';
    document.getElementById("middleName").value = 'A';
    document.getElementById("lastName").value = 'Spellman';
    document.getElementById("suffix").selectedIndex = 0;
    document.getElementById("street1").value = '52 Sharon';
    document.getElementById("street2").value = '';
    document.getElementById("street3").value = '52 sharon rd mystic ct 06355';
    document.getElementById("city").value = 'Mystic';
    document.getElementById("state").selectedIndex = 8;
    document.getElementById("zip").value = '06355';
    document.getElementById("permitNumber").value = '1002102';
    document.getElementById("DOB").value = '04/20/1971';
    document.getElementById("POB").value = 'New London, CT';
}
//fillPage();	
function emptyPage() 
{
    document.getElementById("firstName").value = '';
    document.getElementById("middleName").value = '';
    document.getElementById("lastName").value = '';
    document.getElementById("suffix").selectedIndex = 0;
    document.getElementById("street1").value = '';
    document.getElementById("street2").value = '';
    document.getElementById("street3").value = '';
    document.getElementById("city").value = '';
    document.getElementById("state").selectedIndex = 0;
    document.getElementById("zip").value = '';
    document.getElementById("permitNumber").value = '';
    document.getElementById("DOB").value = '';
    document.getElementById("POB").value = '';
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
    else if (which == "RECEIVER")
        document.getElementById("frame").selectedIndex = other; 
    else
        document.getElementById("frame").selectedIndex = longgun; 
}

