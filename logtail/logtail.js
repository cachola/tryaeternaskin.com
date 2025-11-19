var pausetoggle = "#pause";
var showlog = "code";
var load = 1000 * 1024; /* 1MB */
var poll = 3000; /* 3s */
var stopLog = false;
var pause = false;
var codelog = {
  name: "code",
  log_data: "",
  log_file_size: 0,
  dataelem: "#data",
  dataelemid: "data",
};
var pixelslog = {
  name: "pixels",
  log_data: "",
  log_file_size: 0,
  dataelem: "#data1",
  dataelemid: "data1",
};
var deleteLog = false;

function parseInt2(value) {
  if (!/^[0-9]+$/.test(value)) throw "Invalid integer " + value;
  var v = Number(value);
  if (isNaN(v)) throw "Invalid integer " + value;
  return v;
}

async function get_log(objlog) {
  try {
    var res;
    res = await $.ajax({
      type: "POST",
      url: "ajaxtail.php",
      dataType: "json",
      data: {
        req: "getLog",
        name: objlog.name,
        log_file_size: objlog.log_file_size,
      },
      success: function (data) {
        if (data.code == "200") {
          var added = false;
          if (data.chunk.length > 0) {
            var a = 1;
          }
          if (objlog.log_file_size === 0) {
            /* Clip leading part-line if not the whole file */

            if (data.chunk.length < objlog.log_file_size) {
              var start = data.indexOf("\n");
              objlog.log_data = data.chunk.substring(start + 1);
            } else {
              objlog.log_data = data.chunk;
            }

            added = true;
          } else {
            objlog.log_data += data.chunk;

            if (objlog.log_data.length > load) {
              var start = objlog.log_data.indexOf(
                "\n",
                objlog.log_data.length - load
              );
              objlog.log_data = objlog.log_data.substring(start + 1);
            }

            if (data.chunk.length > 0) added = true;
          }
          objlog.log_file_size = data.log_file_size;
          if (added) show_log(objlog);
        } else {
          $(".display-error").html("<ul>" + data.msg + "</ul>");
          $(".display-error").css("display", "block");
        }
      },
      error: function (xhr, s, t) {
        if (xhr.status == 404) {
          objlog.log_file_size = 0;
          objlog.log_data = "";
          show_log(objlog);
        } else {
          throw "Unknown AJAX Error (status " + xhr.status + ")";
        }
      },
    });

    return res;
  } catch (err) {
    console.log(err);
  }
}

async function get_all_logs() {
  const promise1 = new Promise((resolve, reject) => {
    var res = get_log(codelog);
    resolve(res);
  });
  const promise2 = new Promise((resolve, reject) => {
    var res = get_log(pixelslog);
    resolve(res);
  });
  Promise.all([promise1, promise2]).then((values) => {
    if (deleteLog) {
      deleteLog = false;

      delete_logs();
    } else {
      setTimeout(get_all_logs, poll);
    }
  });
}

function show_log(objlog) {
  if (pause) return;

  var t = objlog.log_data;

  t = t.replace(/\n/g, "\r\n");

  $(objlog.dataelem).text(t);
  document.getElementById(
    objlog.dataelemid
  ).scrollTop = document.getElementById(objlog.dataelemid).scrollHeight;
}

function error(what) {
  $(dataelem).text(
    "An error occured :-(.\r\n" + "Reloading may help; no promises.\r\n" + what
  );
  scroll(0);

  return false;
}

$(document).ready(function () {
  window.onerror = error;
  var stText = logStatus ? "Logging. Stop Log" : "Log Stopped. Start log";
  $("#status").text(stText);
  $("#status").click(function () {
    set_log_status();
  });

  $("#deleteLog").click(function () {
    if (confirm("Delete Log Files?")) {
      deleteLog = true;
    }
  });

  $(pausetoggle).click(function (e) {
    pause = !pause;
    $(pausetoggle).text(pause ? "Unpause" : "Pause");
    if (pause==false){
      show_log(pixelslog);
      show_log(codelog);
    }
    // e.preventDefault();
  });

  $("#interval").change(function (e) {
    var a = $(this).val();
    if (a < 1 || a > 10) {
      a = 3;
      $(this).val(a);
      alert("Enter value between 1 and 10 seconds");
    }
    poll = a * 1000;
  });
  get_all_logs();
});

async function delete_logs() {
  try {
    var res;
    res = await $.ajax({
      type: "POST",
      url: "ajaxtail.php",
      dataType: "json",
      data: { req: "deleteLogs" },
      success: function (data) {
        codelog.log_data = "";
        codelog.log_file_size = 0;
        pixelslog.log_file_size = 0;
        pixelslog.log_data = "";
        get_all_logs();
      },
    });
    return res;
  } catch (err) {
    console.log(err);
  }
}

async function set_log_status() {
  try {
    var res;
    res = await $.ajax({
      type: "POST",
      url: "ajaxtail.php",
      dataType: "json",
      data: { req: "setLogStatus", logStatus: !logStatus },
      success: function (data) {
        logStatus = data.result == "ok" ? !logStatus : logStatus;
        var stText = logStatus ? "Logging. Stop Log" : "Log Stopped. Start log";
        $("#status").text(stText);
      },
      error: function (data) {
        console.log(data);
      },
    });
    return res;
  } catch (err) {
    console.log(err);
  }
}
