<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

function make_radiobutton($_rb_var, $_rb_group){
  $_rb_str = '<input type="radio" name="' . $_rb_group . '" value="' . $_rb_var . '"/>' . $_rb_var ;
  echo $_rb_str;
  // echo $_rb_var;
  }

function make_void_cell(){
  echo "<TD></TD>";
  }

function make_radiobutton_cell($_rb_var, $_rb_group){
  echo "<TD>";
  if ($_rb_var != '') {
    $_rb_str = '<input type="radio" name="' . $_rb_group . '" value="' . $_rb_var . '"/>' . $_rb_var ;
    echo $_rb_str;
    }
  echo "</TD>";
  }

function make_checkbox_cell($_cbx_var, $_cbx_group){
  // http://form.guide/php-form/php-form-checkbox.html
  echo "<TD>";
  $_cbx_group = $_cbx_group . '[]' ;
  if ($_cbx_var != '') {
    $_cbx_str = '<input type="checkbox" name="' . $_cbx_group . '" value="' . $_cbx_var . '"/>' . $_cbx_var ;
    echo $_cbx_str;
    }
  echo "</TD>";
  }

function make_form_cell(){
  // http://form.guide/php-form/php-form-checkbox.html
  echo '<TD>';
  echo '&emsp; &emsp;';
  //echo '<form action="fstb_plot_001.htm" method="post">';
  echo '<button type="reset">reset</button>';
  echo '&emsp;';
  echo '<button type="submit">send</button>';
  //echo '</form>';
  echo '</TD>';
  }


echo "<HTML><HEAD></HEAD><BODY>";

// $db = new SQLite3("feinstaub_0011.db");
$db = new SQLite3("feinstaub_0011_NORM.db");
// $res = $db->query("select * from fstb");

// $res_datum = $db->query("SELECT DISTINCT datum, FROM fstb");
// $res = $db->query("SELECT DISTINCT datum, esp8266id FROM fstb ORDER BY datum, esp8266id");
// $res = $db->query('SELECT DISTINCT date(datum), station_name FROM "values" ORDER BY datum, station_name');
$res = $db->query('SELECT datum, station_name FROM "day_stations" ORDER BY datum, station_name');

if ($res){
  // echo '<form action="fstb_show_001.php" method="post">';
  echo  '<form action="fstb_plot_006.htm" method="post">';
  echo  '<button type="reset">Eingaben zurücksetzen</button>';
  echo  '<button type="submit">Eingaben absenden</button>';
  $_datum_str_old        = "" ;
  $_station_name_str_old = "" ;
  echo "<TABLE>";
  while ($_record = $res -> fetchArray(SQLITE3_ASSOC)){
    $_datum_str = $_record["datum"];
    $_station_name_str = $_record["station_name"];
    if ($_datum_str != ''){
      if ($_datum_str != $_datum_str_old){
        $_datum_str_old = $_datum_str ;
          echo "<TR>";
          make_radiobutton_cell($_datum_str, "datum");
          make_checkbox_cell($_station_name_str, "station_name");
          // echo '&emsp; &emsp;&emsp; &emsp;&emsp; &emsp;&emsp; &emsp;';
          make_void_cell(); make_void_cell();  make_void_cell();
          make_radiobutton_cell("0",   "Intervall");
          make_radiobutton_cell("7",   "Intervall");
          make_radiobutton_cell("31",  "Intervall");
          make_radiobutton_cell("120", "Intervall");
          make_form_cell();
          echo "</TR>";
          }
        else {
          echo "<TR>";
          make_void_cell();
          make_checkbox_cell($_station_name_str, "station_name");
          echo "</TR>";
        }
      }
    }
  echo "</TABLE>";
  echo '</form>';
  }


$db->close();
echo "</BODY></HTML>";
?>
