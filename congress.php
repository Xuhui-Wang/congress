<!doctype html>
<?php
    function returnZero() {
        echo "<br><h1>The API returned zero results for the request</h1>";
    }
    $array  = array(
    "" => "Keyword*",
    "Legislators" => "State/Representative*",
    "Committees" => "Committee ID*",
    "Bills" => "Bill ID*",
    "Amendments" => "Amendment ID*"
    );
    
    $_states = array(
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',
    );
    if (isset($_POST['clear'])) {
        $_POST['congress'] = '';
        $_POST['chamber'] = "senate";
        $_POST["keyword"] = '';
    }
?>
<html>
    <head>
        <title>Forecast</title>
        <style type = "text/css">
            h1 {
                text-align:center;
                font-weight:bolder;
            }
            table {
                margin: 0px auto;
                width: 350px;
                display: table;
                text-align: center;
                border-style: solid;
                border-color: gray;      
            }
            td {
                height: auto;
            }
            table.show{
                margin-top: 20px;
                width: 65%;
                border: 1px solid black;
                border-collapse: collapse;
            }
            th.show, td.show {
                border: 1px solid black;
            }
            div.detail {
                margin: auto;
                margin-top: 20px;
                width: 70%;
                border: 1px solid black;
                border-collapse: collapse;
            }
            table.detail {
                width: 65%;
                border-color: white;
            }
            img.detail {
                display: block;
                margin: auto;
                padding-top: 20px;
                padding-bottom: 20px;
            }
        </style>

    </head>
    <body onchange = "changeCongress()">
        <h1>Congress Information Search</h1>
        <form name = "submit_form" id = "myForm" method = "POST" action = "congress.php" onsubmit = "return checkTable()">       <!--action = "form_processing.php" -->
            <table>
                <tr>
                    <td>
                        Congress Database
                    </td>
                    <td>
                        <select name = "congress" id = "congress">
                            <option value = "" <?php if (isset($_POST['congress']) && $_POST['congress'] == '') echo "selected";?>>Select your option</option>
                            <option value = "Legislators" <?php if (isset($_POST['congress']) && $_POST['congress'] == 'Legislators') echo "selected";?>>Legislators</option>
                            <option value = "Committees" <?php if (isset($_POST['congress']) && $_POST['congress'] == 'Committees') echo "selected";?>>Committees</option>
                            <option value = "Bills" <?php if (isset($_POST['congress']) && $_POST['congress'] == 'Bills') echo "selected";?>>Bills</option>
                            <option value = "Amendments" <?php if (isset($_POST['congress']) && $_POST['congress'] == 'Amendments') echo "selected";?>>Amendments</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Chamber
                    </td>
                    <td>
                        <input type = "radio" name = "chamber" value = "senate" 
                        <?php 
                               if (!isset($_POST['chamber']))
                                  {echo 'checked'; }
                                  else { 
                                      if ($_POST['chamber'] == "senate") 
                                          echo 'checked'; 
                                  }
                        ?>>Senate
                        <input type = "radio" name = "chamber" value = "house" <?php if (isset($_POST['chamber']) && $_POST['chamber'] == "house") echo "checked"; 
                        ?>>House
                    </td>
                </tr>
                <tr>
                    <td>
                        <p name = "keyword" id = "keyword">
                            <?php
                                if (isset($_POST['search']))
                                    echo $array[$_POST['congress']];
                                else        
                                    echo "Keyword*";
                            ?>
                        </p>
                    </td>
                    <td>
                        <input type = "text" name = "keyword" id = "keyword_input" <?php if (isset($_POST['keyword'])) {$_k = $_POST['keyword']; echo "value = '".$_k."'";}   //if (strlen($_k) > 0) ?>> 
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type = "submit" name = "search" value = "Search">
                        <input type = "submit" name = "clear" value = "Clear" onclick = "clearTable()">
                    </td>
                </tr>
                <tr>
                    <td colspan = 2>
                        <a href = "http://sunlightfoundation.com/" target = "_blank">Powered by Sunlight Foundation</a>
                    </td>

                </tr>
            </table> 
        


        <?php 
//            if (isset($_POST)) {
//                echo '<pre>';
//                print_r($_POST);
//                echo '</pre><hr>';
//            }
            if (isset($_POST['search'])) {
//                echo '<pre>';
//                print_r($_POST);
//                echo '</pre>';
                if ($_POST['congress'] == 'Legislators') {
                    $_state_code = "";
                    foreach ($_states as $k => $v) {
                        if (strtoupper($v) == strtoupper($_POST['keyword']))
                            $_state_code = $k;
                    }
                    if (!empty($_state_code)) {
                        $_url = "http://congress.api.sunlightfoundation.com/legislators?chamber=".$_POST['chamber']."&state=".$_state_code."&apikey=4ae7fc8356ba4501aad3260f043285f5";
                    } else {
                        $_url = "http://congress.api.sunlightfoundation.com/legislators?chamber=".$_POST['chamber']."&query=".urlencode($_POST['keyword'])."&apikey=4ae7fc8356ba4501aad3260f043285f5";
                    }
                    //echo '<pre>'.$_url.'</pre>';             // this is for test;
                    $_contents = file_get_contents($_url);
                    $_objs = json_decode($_contents, true);
//                    echo '<pre>';
//                    print_r($_objs);
//                    echo '</pre>';
                    if ($_objs['count'] == 0)
                        returnZero();
                    else {
                        echo "\n";
                        echo '<table class = "show">';
                        echo "\n";
                        echo '<tr><th class = "show">Name</th><th class = "show">State</th><th class = "show">Chamber</th><th class = "show">View Details</th></tr>';
                        for ($var = 0; $var < count($_objs['results']); $var++) {
                            $_obj = $_objs['results'][$var];
                            echo "\n";
                            echo '<tr><td class = "show">';
                            echo $_obj['first_name']." ".$_obj['last_name'];
                            echo '</td>';
                            echo '<td class = "show">';
                            echo $_obj['state_name'];
                            echo '</td>';
                            echo '<td class = "show">';
                            echo $_obj['chamber'];
                            echo '</td>';
                            echo '<td class = "show"><a href = "javascript:displayDetails(';
                            echo "'";
                            echo $_obj['bioguide_id'];
                            echo "', '";
                            if (isset($_obj['title']))
                                echo $_obj['title'];
                            echo "', '";
                            if (isset($_obj['first_name']))
                                echo $_obj['first_name'];
                            echo "', '";
                            if (isset($_obj['last_name']))
                                echo $_obj['last_name'];
                            echo "', '";
                            if (isset($_obj['term_end']))
                                echo $_obj['term_end'];
                            echo "', '";
                            if (isset($_obj['website']))
                                echo $_obj['website'];
                            echo "', '";
                            if (isset($_obj['office']))
                                echo $_obj['office'];
                            echo "', '";
                            if (isset($_obj['facebook_id']))
                                echo $_obj['facebook_id'];
                            echo "', '";
                            if (isset($_obj['twitter_id']))
                                echo $_obj['twitter_id'];
                            echo "'";
                            echo ')"'.'>View Details</a></td>';
                            echo '</tr>';
                        }
                        echo "</table>";
                        echo "\n";
                    }
                } elseif ($_POST['congress'] == 'Committees') {
                    $_committee_id = strtoupper($_POST['keyword']);
                    $_url = "http://congress.api.sunlightfoundation.com/committees?committee_id=".rawurlencode($_committee_id)."&chamber=".$_POST['chamber']."&apikey=4ae7fc8356ba4501aad3260f043285f5";
                    //echo "url: ".$_url;
                    $_contents = file_get_contents($_url);
                    $_objs = json_decode($_contents, true);
                    if ($_objs['count'] == 0)
                    {
                        returnZero();
                    } else {
                        echo "\n";
                        echo '<table class = "show">';
                        echo "\n";
                        echo '<tr><th class = "show">Committee ID</th><th class = "show">Committee Name</th><th class = "show">Chamber</th></tr>';
                        for ($var = 0; $var < count($_objs['results']); $var++) {
                            $_obj = $_objs['results'][$var];
                            echo "\n";
                            echo '<tr><td class = "show">';
                            if (isset($_obj['committee_id']))
                                echo $_obj['committee_id'].'</td>';
                            else 
                                echo "NA".'</td>';
                            echo "\n";
                            echo '<td class = "show">';
                            if (isset($_obj['name']))
                                echo $_obj['name'].'</td>';
                            else 
                                echo "NA".'</td>';
                            echo "\n";
                            echo '<td class = "show">';
                            if (isset($_obj['chamber']))
                                echo $_obj['chamber'].'</td></tr>';
                            else
                                echo "NA".'</td></tr>';
                        }
                        echo "</table";
                    }
                } elseif ($_POST['congress'] == 'Bills') {
                    $_bill_id = $_POST['keyword'];   //strtoupper()
                    $_url = "http://congress.api.sunlightfoundation.com/bills?bill_id=".rawurlencode($_bill_id)."&chamber=".$_POST['chamber']."&apikey=4ae7fc8356ba4501aad3260f043285f5";
                    $_contents = file_get_contents($_url);
                    $_objs = json_decode($_contents, true);
//                    echo "<pre>";
//                    print_r($_objs);
//                    echo "</pre>";
                    if ($_objs['count'] == 0)
                    {
                        //echo "<h1> haha </h1>";
                        returnZero();
                    } else {
                        echo "\n";
                        echo '<table class = "show">';
                        echo "\n";
                        echo '<tr><th class = "show">Bill ID</th><th class = "show">Short Title</th><th class = "show">Chamber</th><th class = "show">Details</th></tr>';
                        for ($var = 0; $var < count($_objs['results']); $var ++) {
                            $_obj = $_objs['results'][$var];
                            echo "\n";
                            echo '<tr><td class = "show">';
                            if (isset($_obj['bill_id']))
                                echo $_obj['bill_id'];
                            else
                                echo "NA";
                            echo '</td>';
                            echo '<td class = "show">';
                            if (isset($_obj['short_title']))
                                echo $_obj['short_title'];
                            else
                                echo "NA";
                            echo '</td>';
                            echo '<td class = "show">';
                            echo $_obj['chamber'];
                            echo '</td>';
                            echo '<td class = "show"><a href = "javascript:displayBillDetails(';
                            echo "'";
                            if (isset($_obj['bill_id']))
                                echo $_obj['bill_id'];
                            echo "', '";
                            if (isset($_obj['short_title']))
                                echo $_obj['short_title'];
                            echo "', '";
                            if (isset($_obj['sponsor']['title']))
                                echo $_obj['sponsor']['title'];
                            echo "', '";
                            if (isset($_obj['sponsor']['first_name']))
                                echo $_obj['sponsor']['first_name'];
                            echo "', '";
                            if (isset($_obj['sponsor']['last_name']))
                                echo $_obj['sponsor']['last_name'];
                            echo "', '";
                            if (isset($_obj['introduced_on']))
                                echo $_obj['introduced_on'];
                            echo "', '";
                            if (isset($_obj['last_version']['version_name']))
                                echo $_obj['last_version']['version_name'];
                            echo "', '";
                            if (isset($_obj['last_action_at']))
                                echo $_obj['last_action_at'];
                            echo "', '";
                            if (isset($_obj['last_version']['urls']['pdf']))
                                echo $_obj['last_version']['urls']['pdf'];
                            echo "'";
                            echo ')"'.'>View Details</a></td>';
                            echo '</tr>';
                        }
                        echo "</table>";
                        echo "\n";
                    }
                } else {
                    $_amendment_id = $_POST['keyword'];   //strtoupper()
                    $_url = "http://congress.api.sunlightfoundation.com/amendments?amendment_id=".rawurlencode($_amendment_id)."&chamber=".$_POST['chamber']."&apikey=4ae7fc8356ba4501aad3260f043285f5";
                    $_contents = file_get_contents($_url);
                    $_objs = json_decode($_contents, true);
//                    echo "<pre>";
//                    print_r($_objs);
//                    echo "</pre>";
                    if ($_objs['count'] == 0)
                    {
                        //echo "<h1> haha </h1>";
                        returnZero();
                    } else {
                        echo "\n";
                        echo '<table class = "show">';
                        echo "\n";
                        echo '<tr><th class = "show">Amendment ID</th><th class = "show">Amendment Type</th><th class = "show">Chamber</th><th class = "show">Introduced on</th></tr>';
                        for ($var = 0; $var < count($_objs['results']); $var ++) {
                            $_obj = $_objs['results'][$var];
                            echo "\n";
                            echo '<tr><td class = "show">';
                            if (isset($_obj['amendment_id']))
                                echo $_obj['amendment_id'];
                            else
                                echo "NA";
                            echo '</td>';
                            echo '<td class = "show">';
                            if (isset($_obj['amendment_type']))
                                echo $_obj['amendment_type'];
                            else
                                echo "NA";
                            echo '</td>';
                            echo '<td class = "show">';
                            if (isset($_obj['chamber']))
                                echo $_obj['chamber'];
                            else
                                echo "NA";
                            echo '</td>';
                            echo '<td class = "show">';
                            if (isset($_obj['introduced_on']))
                                echo $_obj['introduced_on'];
                            else
                                echo "NA";
                            echo '</td>';                            
                            echo '</tr>';
                        }
                        echo "</table>";
                        echo "\n";
                    }
                }
            }
        ?>
        </form>
        
             <script type = "text/javascript">
                function changeCongress() {
                    var cong = document.getElementById("congress");
                    var words = ["Keyword*", "State/Representative*", "Committee ID*", "Bill ID*", "Amendment ID*"];
                    document.getElementById("keyword").innerHTML =  words[cong.selectedIndex];    
                }
                function checkTable() {
                    var cong = document.getElementById("congress").value.trim();
                    var key = document.getElementById("keyword_input").value.trim();
                    if (cong.length == 0 || key.length == 0) {
                        var msg = "Please enter the following missing information: ";
                        if (cong.length == 0 && key.length == 0)
                            msg += "Congress database" + ", " + "keyword";
                        else if (cong.length == 0)
                            msg += "Congress database";
                        else 
                            msg += "keyword";
                        alert(msg);
                        return false;
                    }
                    else {
                        //alert("length: " + cong.length + ", " + key.length);
                        return true;
                    }
                }
                function clearTable() {
                    document.getElementById("myForm").reset();
                }
                function displayDetails(bioguide_id, title, first_name, last_name, term_end, website, office, facebook_id, twitter_id) {  //
                    var form = document.getElementById('myForm');
                    var tables = form.getElementsByTagName('table');
                    form.removeChild(tables[1]);
                    var newForm = document.createElement("div");
                    newForm.className = "detail";
                    var img = document.createElement("img");
                    img.src = 'https://theunitedstates.io/images/congress/225x275/' + bioguide_id + ".jpg";
                    img.className = 'detail';
                    newForm.appendChild(img);

                    var newTable = document.createElement("table");
                    newTable.className = "detail";
//                    
                    var nameRow = document.createElement("tr");
                    var nameL = document.createElement("td");
                    var nameR = document.createElement("td");
                    var nameLText = document.createTextNode("Full Name");
                    if ((typeof first_name != 'undefined' && first_name) || (typeof last_name != 'undefined' && last_name))
                        var nameRText = document.createTextNode(title + " " + first_name + " " + last_name);
                    else 
                        var nameRText = document.createTextNode("NA");
                    nameL.appendChild(nameLText);
                    nameR.appendChild(nameRText);
                    nameRow.appendChild(nameL);
                    nameRow.appendChild(nameR);
                    newTable.appendChild(nameRow);
                    
                    var termRow = document.createElement("tr");
                    var termL = document.createElement("td");
                    var termR = document.createElement("td");
                    var termLText = document.createTextNode("Term Ends On");
                    if (typeof term_end != 'undefined' && term_end)
                        var termRText = document.createTextNode(term_end);
                    else
                        var termRText = document.createTextNode("NA");
                    termL.appendChild(termLText);
                    termR.appendChild(termRText);
                    termRow.appendChild(termL);
                    termRow.appendChild(termR);
                    newTable.appendChild(termRow);
                    
                    var websiteRow = document.createElement("tr");
                    var websiteL = document.createElement("td");
                    var websiteR = document.createElement("td");
                    var websiteLText = document.createTextNode("Website");
                    if (typeof website != 'undefined' && website)
                    {
                        var text = document.createTextNode(website);
                        var websiteRText = document.createElement("a");
                        websiteRText.href = website;
                        websiteRText.target = "_blank";
                        websiteRText.appendChild(text);
                    }
                    else
                        var websiteRText = document.createTextNode("NA");
                    websiteL.appendChild(websiteLText);
                    websiteR.appendChild(websiteRText);
                    websiteRow.appendChild(websiteL);
                    websiteRow.appendChild(websiteR);
                    newTable.appendChild(websiteRow);
                    
                    var officeRow = document.createElement("tr");
                    var officeL = document.createElement("td");
                    var officeR = document.createElement("td");
                    var officeLText = document.createTextNode("Office");
                    if (typeof office != 'undefined' && office)
                    {
                        var officeRText = document.createTextNode(office);
                    }
                    else
                        var officeRText = document.createTextNode("NA");
                    officeL.appendChild(officeLText);
                    officeR.appendChild(officeRText);
                    officeRow.appendChild(officeL);
                    officeRow.appendChild(officeR);
                    newTable.appendChild(officeRow);
                    
                    var fbRow = document.createElement("tr");
                    var fbL = document.createElement("td");
                    var fbR = document.createElement("td");
                    var fbLText = document.createTextNode("Facebook");
                    if (typeof facebook_id != 'undefined' && facebook_id)
                    {
                        var fbRText = document.createElement("a");
                        fbRText.href = "https://www.facebook.com/" + facebook_id;
                        fbRText.target = "_blank";
                        var text = document.createTextNode(first_name + " " + last_name);
                        fbRText.appendChild(text);
                    }
                    else
                        var fbRText = document.createTextNode("NA");
                    fbL.appendChild(fbLText);
                    fbR.appendChild(fbRText);
                    fbRow.appendChild(fbL);
                    fbRow.appendChild(fbR);
                    newTable.appendChild(fbRow);
                    
                    var twitterRow = document.createElement("tr");
                    var twitterL = document.createElement("td");
                    var twitterR = document.createElement("td");
                    var twitterLText = document.createTextNode("Twitter");
                    if (typeof twitter_id != 'undefined' && twitter_id)
                    {
                        var twitterRText = document.createElement("a");
                        twitterRText.href = "https://twitter.com/" + twitter_id;
                        twitterRText.target = "_blank";
                        var text = document.createTextNode(first_name + " " + last_name);
                        twitterRText.appendChild(text);
                    }
                    else
                        var twitterRText = document.createTextNode("NA");
                    twitterL.appendChild(twitterLText);
                    twitterR.appendChild(twitterRText);
                    twitterRow.appendChild(twitterL);
                    twitterRow.appendChild(twitterR);
                    newTable.appendChild(twitterRow);
                    
                    newForm.appendChild(newTable);
                    form.appendChild(newForm);    // add <div> to <form>
                }
                
                function displayBillDetails(bill_id, short_title, title, first_name, last_name, introduced_on, version_name, last_action_at, pdf) {  //
                    var form = document.getElementById('myForm');
                    var tables = form.getElementsByTagName('table');
                    form.removeChild(tables[1]);
                    var newDiv = document.createElement("div");
                    newDiv.className = "detail";
                    
                    var newTable = document.createElement("table");
                    newTable.className = "detail";
//                    
                    var idRow = document.createElement("tr");
                    var idL = document.createElement("td");
                    var idR = document.createElement("td");
                    var idLText = document.createTextNode("Bill ID");
                    var idRText = document.createTextNode(bill_id);
                    idL.appendChild(idLText);
                    idR.appendChild(idRText);
                    idRow.appendChild(idL);
                    idRow.appendChild(idR);
                    newTable.appendChild(idRow);
                    
                    var titleRow = document.createElement("tr");
                    var titleL = document.createElement("td");
                    var titleR = document.createElement("td");
                    var titleLText = document.createTextNode("Bill Title");
                    if (typeof short_title != 'undefined' && short_title)
                        var titleRText = document.createTextNode(short_title);
                    else
                        var titleRText = document.createTextNode("NA");
                    titleL.appendChild(titleLText);
                    titleR.appendChild(titleRText);
                    titleRow.appendChild(titleL);
                    titleRow.appendChild(titleR);
                    newTable.appendChild(titleRow);
                    
                    var sponsorRow = document.createElement("tr");
                    var sponsorL = document.createElement("td");
                    var sponsorR = document.createElement("td");
                    var sponsorLText = document.createTextNode("Sponsor");
                    if ((typeof first_name != 'undefined' && first_name) || (typeof last_name != 'undefined' && last_name))
                    {
                        var sponsorRText = document.createTextNode(title + " " + first_name + " " + last_name);
                    }
                    else
                        var sponsorRText = document.createTextNode("NA");
                    sponsorL.appendChild(sponsorLText);
                    sponsorR.appendChild(sponsorRText);
                    sponsorRow.appendChild(sponsorL);
                    sponsorRow.appendChild(sponsorR);
                    newTable.appendChild(sponsorRow);
                    
                    var introduceRow = document.createElement("tr");
                    var introduceL = document.createElement("td");
                    var introduceR = document.createElement("td");
                    var introduceLText = document.createTextNode("Introduced On");
                    if (typeof introduced_on != 'undefined' && introduced_on)
                    {
                        var introduceRText = document.createTextNode(introduced_on);
                    }
                    else
                        var introduceRText = document.createTextNode("NA");
                    introduceL.appendChild(introduceLText);
                    introduceR.appendChild(introduceRText);
                    introduceRow.appendChild(introduceL);
                    introduceRow.appendChild(introduceR);
                    newTable.appendChild(introduceRow);
                    
                    var lastactionRow = document.createElement("tr");
                    var lastactionL = document.createElement("td");
                    var lastactionR = document.createElement("td");
                    var lastactionLText = document.createTextNode("Last action with date");
                    if (typeof last_action_at != 'undefined' && last_action_at)
                    {
                        var lastactionRText = document.createTextNode(version_name + ", " + last_action_at);
                        
                    }
                    else
                        var lastactionRText = document.createTextNode("NA");
                    lastactionL.appendChild(lastactionLText);
                    lastactionR.appendChild(lastactionRText);
                    lastactionRow.appendChild(lastactionL);
                    lastactionRow.appendChild(lastactionR);
                    newTable.appendChild(lastactionRow);
                    
                    var billurlRow = document.createElement("tr");
                    var billurlL = document.createElement("td");
                    var billurlR = document.createElement("td");
                    var billurlLText = document.createTextNode("Bill URL");
                    if (typeof pdf != 'undefined' && pdf && typeof short_title != 'undefined' && short_title)
                    {
                        var billurlRText = document.createElement("a");
                        billurlRText.href = pdf;
                        billurlRText.target = "_blank";
                        var text = document.createTextNode(short_title);
                        billurlRText.appendChild(text);
                    }
                    else
                        var billurlRText = document.createTextNode("NA");
                    billurlL.appendChild(billurlLText);
                    billurlR.appendChild(billurlRText);
                    billurlRow.appendChild(billurlL);
                    billurlRow.appendChild(billurlR);
                    newTable.appendChild(billurlRow);
                    
                    newDiv.appendChild(newTable);
                    form.appendChild(newDiv);    // add <div> to <form>
                }
            </script>
    </body>
</html>
