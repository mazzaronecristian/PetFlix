  jQuery(document).ready(function () {
    console.log("OPTIONS PLUGIN IS READY");
    jQuery(".switch").switches({ serverURL: "server/actionsOptions.php" });
    jQuery(".selector").selectors({ serverURL: "server/actionsOptions.php" });
  });