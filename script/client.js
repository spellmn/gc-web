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
      else {
        invocation.open('GET', url, true);
        //invocation.responseType = 'json';
        invocation.onreadystatechange = handler;
        invocation.send();
      }
    }
    else {
      var text = "No Invocation TookPlace At All";
      var textNode = document.createTextNode(text);
      var textDiv = document.getElementById("textDiv");
      textDiv.appendChild(textNode);
    }
  }

  function handler(evtXHR) {
    if (invocation.readyState == 4)
    {
      if (invocation.status == 200) {
          outputResult();
      }
      else {
        alert("Invocation Errors Occured: Status " + invocation.status);
      }
    }
  }

  function outputResult() {
    var response = invocation.responseText;
//    alert(response);
    response = response.substring(1, response.length-1);
//    alert(response);

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

