<head>
<link rel="stylesheet" type="text/css" href="teachercss.css">
</head>
<?php 
  if (isset($_POST['lesson_id'])){insertreq();}
  if (isset($_POST['remrid'])){removereq($_POST['remrid']);}
  if (isset($_POST['updrid'])){updatereq($_POST['updrid']);}
  $weekdates = getStartAndEndDate(date('W')-1,date('Y'));
?>


<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'thisweek')">This Week <?php echo $weekdates[0][0], ' - ', $weekdates[0][6]; ?></button>
  <button class="tablinks" onclick="openCity(event, 'nextweek')">Next Week <?php echo $weekdates[1][0], ' - ', $weekdates[1][6]; ?></button>
</div>


  <div class="modals">
    <?php 
	generateModal("create");
    generateModal("info");
	?>
  </div>


<div id="thisweek" class="tabcontent">
  <?php 
	   $week=$weekdates[0][7];
	   echo "<span class='weekLetter'><p> $week - $teach</p></span>";

      echo '<div class="selectTeacher">';
      $teachers=getTeachers();
      foreach($teachers as $tea) {
          echo "<button class='teacherOption' onclick=openTeacher('$tea')>$tea</button>";
      }
      echo '</div>';

      generateTable(0);
  ?>
</div>

<div id="nextweek" class="tabcontent">
  <?php 
	   $week=$weekdates[1][7];
       echo "<span class='weekLetter'><p> $week - $teach </p></span>";

      echo '<div class="selectTeacher">';
      $teachers=getTeachers();
      foreach($teachers as $tea) {
          echo "<button class='teacherOption' onclick=openTeacher('$tea')>$tea</button>";
      }
      echo '</div>';

       generateTable(1);
  ?> 
</div>

<div id="Tokyo" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>

<script>
  var tab = sessionStorage.getItem("sessionTab");
  if (tab) { openCity(event, tab); }

function openCity(evt, weekview) {
    var i, tabcontent, tablinks;
	sessionStorage.sessionTab = weekview;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(weekview).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>

<script>

    var modal = document.getElementById('myModal');
    var modal2 = document.getElementById('myModal2');
    var modal3 = document.getElementById('myModal3');
    var close1 = document.getElementsByClassName("close")[0];
    var cancel = document.getElementsByClassName("cancel")[0];
    var cancel2 = document.getElementsByClassName("cancel2")[0];

    function openTeacher(tea) {
        var loc = window.location.href;
        if (loc.indexOf("?")>-1){
            loc = loc.substr(0,loc.indexOf("?"));
        }
        window.location.assign(loc + "?teach=" +tea);
    }

    function fillContent(type,t,d,ras,rac,rid,lid) {

        close1.onclick = function() {
            modal.style.display = "none";
            document.getElementsByTagName("body")[0].style ='overflow:visible';
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                document.getElementsByTagName("body")[0].style ='overflow:visible';
            }
        };

        if (type == "info") {
            modal.style.display = "block";
            document.getElementsByTagName("body")[0].style ='overflow:hidden';
            var title = document.getElementById('title');
            var desc = document.getElementById('desc');
            var rass = document.getElementById('ras');
            var racc = document.getElementById('rac');
            var editButton = document.getElementById('editButton');
            document.getElementById('infTitle').innerHTML=lid;

            document.getElementById('rid').value=rid;
            title.innerHTML=t;
            desc.innerHTML=d;
            rass.innerHTML=ras;
            racc.innerHTML=rac;
            editButton.onclick = function() { fillContent('edit', t, d, ras, rac, rid, lid); };

        }
        else if (type == "create") {
            document.getElementsByTagName("body")[0].style ='overflow:hidden';
            modal2.style.display = "block";
            var title = document.getElementById('reqfor');
            document.getElementById('lesson_id').value=d;
            title.innerHTML=t;
            cancel.onclick = function() {
                modal2.style.display = "none";
                document.getElementsByTagName("body")[0].style ='overflow:visible';
            };
        }
        else if (type == "edit") {
            modal3.style.display = "block";
            document.getElementById('edTitle').innerHTML=lid;
            document.getElementById('editreqid').value=rid;
            document.getElementById('edittitle').value=t;
            document.getElementById('editdesc').value=d.replace(/<br\/>/g, '\n');
            if (ras =="YES") { document.getElementById('editrassyes').checked="checked"; }
            else { document.getElementById('editrassno').checked="checked"; }
            document.getElementById('editracc').value=rac.replace(/<br\/>/g, '\n');

            cancel2.onclick = function() {
                modal3.style.display = "none";
            };
        }

    }
</script>

</html>
