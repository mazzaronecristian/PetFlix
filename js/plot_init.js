jQuery(document).ready(function () {
  console.log("PLOT PLUGIN IS READY");
  jQuery(".plot-peso").plot({ serverURL: "server/plot.php" });
});
