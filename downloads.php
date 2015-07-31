    <h1 class="title"><?=$CuteExplorer->get_config('title')?></h1>
<?php
// If the user is not logged in, show the login form.
if(!isset($_SESSION['users'])) {
// If the user tried access a protected file or folder,
// show the info message.
if($CuteExplorer->get_value('error_code') == 403) {
    printf("%4s%s\n", "", "<p>You don't have permission to access the requested page or file.</p>");
    printf("%4s%s\n", "", "<p>Please, if you need to access, login in the form bellow.</p>");
}
?>
    <form method="post" action="">
        <p class="login">
            User: <input type="text" pattern=".{3,}" required title="You need at least 3 characters" name="user" size="20">
            Password: <input type="password" pattern=".{5,}" required title="You need at least 5 characters" name="passwd" size="20">
            <input type="submit" name="login" value="Login">
        </p>
    </form>
<?php
    // If the user or password is incorrect, show a info message.
    if(isset($_POST['login'])) {
        printf("%8s%s", "", "Incorrect login. Try again.");
    }
// If the user is already logged in, show the user info and logout button.
} else {
?>
    <form method="post" action="">
        <p>
            You are logged in as <?=$_SESSION['users']?>.
            <input type="submit" name="logout" value="Logout">
        </p>
    </form>
<?php
}

if($CuteExplorer->get_value('dir')) {
    printf("%4s%s\n", "", "<p class='current_directory'>~".$CuteExplorer->get_value('dir')."</p>");
} else {
    printf("%4s%s\n", "", "<p class='current_directory'>~/</p>");
}?>
    <table>
        <tr class="header">
            <td class="icon"></td>
            <td class="name"><a>Name</a></td>
            <td class="size"><a>Size</a></td>
            <td class="mtime"><a>Modified Time</a></td>
        </tr>
<?php
    // make a item for previous directory
    if($CuteExplorer->get_value('dir')) {
?>
        <tr onclick="window.location='<?=$CuteExplorer->make_query($CuteExplorer->get_previous_dir($_GET['dir']))?>'">
            <td class="icon">
                <img src="<?=$CuteExplorer->set_icon($_GET['dir'])?>" width="<?=$CuteExplorer->get_config('icon_size')?>" height=auto />
            </td>
            <td class="name" colspan=3>
                <a href="<?=$CuteExplorer->make_query($CuteExplorer->get_previous_dir($_GET['dir']))?>">..</a>
            </td>
        </tr>
<?php }
    // make a item for each folder
    foreach($CuteExplorer->directories as $current_directory) {
?>
        <tr onclick="window.location='<?=$CuteExplorer->make_query($current_directory)?>'">
            <td class="icon">
                <img src="<?=$CuteExplorer->set_icon($current_directory)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" height=auto />
            </td>
            <td class="name"><?=basename($current_directory)?></td>
            <td class="size center" colspan=2>Folder</td>
        </tr>
<?php
    }
    // make a item for each file
    foreach($CuteExplorer->files as $current_file) {
?>
        <tr onclick="window.location='<?=$CuteExplorer->make_link($current_file)?>'">
            <td class="icon">
                <img src="<?=$CuteExplorer->set_icon($current_file)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" height=auto />
            </td>
            <td class="name"><?=$current_file?></td>
            <td class="size"><?=$CuteExplorer->get_file_size($current_file)?></td>
            <td class="mtime"><?=$CuteExplorer->get_file_mtime($current_file)?></td>
        </tr>
<?php
    }
?>
    </table>
    <p>Cute PHP Explorer © 2015 &lt;dev@lara.click&gt;</p>
    <p>The icons are based on MeliaSVG icon theme pack.<br/>
       Thanks to Andrea Soragna.</p>
