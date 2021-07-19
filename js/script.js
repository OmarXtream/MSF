hide();
function hide() {
  var x = document.getElementsByClassName('hideable');
  var i;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
}
var link = document.createElement("link");
link.type = "text/css";
link.rel = "stylesheet";
link.href = "css/dark.css";

afterLoad();
function afterLoad() {
    document.getElementById("missions").style.display = "block";
    document.getElementById('missionsb').classList.add("active");
    var head = document.head;
    head.appendChild(link);
    animateCSS("#missions", "fadeIn");

    var element = document.getElementsByClassName("part");
    for (var b = 0; b < element.length; b++) {element[b].style.visibility = "hidden";}

    var i = 0;
    var x;
    var a = setInterval(function() {
      if (i < element.length) {
        element[i].style.visibility = "visible";
        x = "#" + "part" + i;
        animateCSS(x, 'bounceInDown');
        i++;
        } else {
          clearInterval(a);
        }
      }, 250);
}

function animateCSS(element, animationName, callback) {
    const node = document.querySelector(element)
    node.classList.add('animated', animationName)

    function handleAnimationEnd() {
        node.classList.remove('animated', animationName)
        node.removeEventListener('animationend', handleAnimationEnd)

        if (typeof callback === 'function') callback()
    }

    node.addEventListener('animationend', handleAnimationEnd)
}


function sections(eID) {
  hide();
  var x = document.getElementById(eID);
  x.style.display = "block";

  var a = document.getElementsByClassName('nav');
  var i;
  for (i = 0; i < a.length; i++) {
    a[i].classList.remove("active");
  }

  if (eID == "missions") {
    document.getElementById('missionsb').classList.add("active");
  } else if (eID == "members") {
    document.getElementById('membersb').classList.add("active");
  } else if (eID == "missionsmanagement") {
    document.getElementById('missionsmanagementb').classList.add("active");
  } else if (eID == "membersmanagement") {
    document.getElementById('membersmanagementb').classList.add("active");
  } else if (eID == "log") {
    document.getElementById('logb').classList.add("active");
  } else if (eID == "payments") {
    document.getElementById('paymentsb').classList.add("active");
  } else if (eID == "logout") {
    document.getElementById('logoutb').classList.add("active");
  }

  animateCSS("#"+eID, "fadeIn");
}

function theme() {
  var head = document.head;
  if (document.getElementById("ThemCheckbox").checked) {
    head.appendChild(link);
  }
  else {
    head.removeChild(link);;
  }
}
