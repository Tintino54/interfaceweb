        function addLoadText(){
            var titre=document.getElementById("formdiv");
            alert(titre);
            var texteChargement=document.createElement("p");
            var txt=document.createTextNode("chargement...");
            var img=document.createElement("img");
            img.setAttribute("src","view/ressources/gif_chargement.gif");
            titre.appendChild(texteChargement);
            texteChargement.appendChild(txt);
            texteChargement.appendChild(img);
        }

        function request(){
          alert("appel fonction");
          addLoadText();
          var xmlhttp;
          if (window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
          }
          else{
            // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                var titre=document.getElementById("corpPage");
                var txt=document.createTextNode(xmlhttp.responseText);                      
                titre.replaceChild(txt,titre.lastChild);
            }
          }
          xmlhttp.open("POST","grapheInstanceNK.php?var1=nk_128_2_0",true);
          xmlhttp.send();
        } 