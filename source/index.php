<?php
session_start();
$session_idd = session_id();
?>

<html>

<head>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <style>
    .block_jackpot_join {
      margin: auto;
      padding: 20px;
      width: 450px;
      height: 400px;
      border: 2px solid #555aff;
      margin-top: 20%;
    }

    .block_jackpot_joined {
      width: 350px;
      height: 400px;
      border: 2px solid #555aff;
      padding: 20px;
      margin-top: 20%;
      margin-left: -25%;
      display: none;
    }

    .button_join {
      padding: 15px;
      font-weight: 600;
      background: #555aff;
      border: 2px solid #555aff;
      color: #fff;
      border-radius: 3px;
    }

    .center {
      text-align: center;
    }

    .add_to_pool {
      padding-top: 9px;
      padding-bottom: 13px;
      font-size: 20px;
      font-weight: 600;
      text-align: center;
    }

    #clockdiv {
      font-family: sans-serif;
      color: #fff;
      display: inline-block;
      font-weight: 100;
      text-align: center;
      font-size: 30px;
    }

    #clockdiv>div {
      padding: 10px;
      border-radius: 3px;
      display: inline-block;
    }

    #clockdiv div>span {
      padding: 15px;
      padding-bottom: 10px;
      padding-top: 10px;
      border-radius: 3px;
      background: #555aff;
      display: inline-block;
    }

    .smalltext {
      padding-top: 5px;
      font-size: 16px;
      color: black;
    }
  </style>
</head>

<body>

  <div class="container" style="height: 100%; display: flex;">
    <span style="position: absolute;  top: 20px; right: 20px;">Coins: <span id="balance"></span> BTC</span>
    <div class="block_jackpot_join">
      <div style="position: relative; float: right; margin-right: -15px; margin-top: -15px;">
        <span>Pool #<span id="id_pool"></span></span>
      </div>
      <div class="col-sm-12 center" style="display: inline-grid;">
        <span style="font-size: 22px; font-weight: 500;">To start</span>
        <div id="clockdiv">
          <div>
            <span class="days"></span>
            <div class="smalltext">Days</div>
          </div>
          <div>
            <span class="hours"></span>
            <div class="smalltext">Hours</div>
          </div>
          <div>
            <span class="minutes"></span>
            <div class="smalltext">Minutes</div>
          </div>
          <div>
            <span class="seconds"></span>
            <div class="smalltext">Seconds</div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 center" style="display: inline-grid; margin-top: 30px;">
        <span style="font-size: 22px; font-weight: 500;">Pool:</span>
        <span style="font-size: 20px; font-weight: 500;"><span id="jackpot_pool"></span> BTC </span>
      </div>

      <div class="col-sm-12 center" id="join_button" style="margin-top: 50px;">
        <button class="button_join" onClick="show_pool_join_panel()"> JOIN NOW </button>
      </div>

      <div class="col-sm-12 center" id="show_pool_join_panel" style="margin-top: 50px; display: none;">
        <input type="text" name="add_to_pool" id="add_to_pool" class="add_to_pool">
        <button class="button_join" onClick="join_pool_check()"> IM JOINING! </button>

      </div>

    </div>

    <div class="block_jackpot_joined" id="block_jackpot_joined">

    </div>

  </div>

  <script>
    var pool;
    var member_id =0;
    var member = member_id;
    var member_balance =0;
    var active_pool_id;
    var data1;
    var currentSessionId = '<?php echo session_id(); ?>';
    console.log(currentSessionId);
    function getTimeRemaining(endtime) {
      var t = Date.parse(endtime) - Date.parse(new Date());
      var seconds = Math.floor((t / 1000) % 60);
      var minutes = Math.floor((t / 1000 / 60) % 60);
      var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
      var days = Math.floor(t / (1000 * 60 * 60 * 24));
      return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
      };
    }

    function initializeClock(id, endtime) {
      var clock = document.getElementById(id);
      var daysSpan = clock.querySelector('.days');
      var hoursSpan = clock.querySelector('.hours');
      var minutesSpan = clock.querySelector('.minutes');
      var secondsSpan = clock.querySelector('.seconds');

      function updateClock() {
        var t = getTimeRemaining(endtime);

        daysSpan.innerHTML = t.days;
        hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
        minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

        if (t.total <= 0) {
          clearInterval(timeinterval);
        }
      }

      updateClock();
      var timeinterval = setInterval(updateClock, 1000);
    }

    function getPool() {
      $.ajax({
        data: {
          data1: data1
        },
        type: 'GET',
        url: "get_active_pool.php",
        success: function(pool) {
          $('#jackpot_pool').text(pool);
        }
      });
    }

    function getPoolID() {
      $.ajax({
        data: {
          data1: data1
        },
        type: 'GET',
        url: "get_active_pool_id.php",
        success: function(pool_id) {
          $('#id_pool').text(pool_id);
        }
      });
    }

    function getPoolStartDate() {
      $.ajax({
        data: {
          data1: data1
        },
        type: 'GET',
        url: "get_pool_start_date.php",
        success: function(date) {
          initializeClock('clockdiv', date);
        }
      });
    }
    getPoolStartDate();

    function getBalance() {
      $.ajax({
        data: {
            session_id: currentSessionId
        },
        dataType: 'text',
        type: 'GET',
        url: "get_user_balance.php",
        success: function(balance) {
          member_balance = balance;
          $('#balance').text(balance);
        }
      });
    }

function displayJoinedMembers() {
    $.ajax({
        method: 'GET',
        url: 'get_joined_members.php',
            data: {
            pool_id: '1'
        },
        success: function (data) {
            var joinedMembersDiv = $('#block_jackpot_joined');
            joinedMembersDiv.empty(); 


var dataArray = JSON.parse(data);
var totalAddedToPool = 0;
dataArray.forEach(function (item) {
    // Sprawdzenie, czy klucz "added_to_pool" istnieje i czy jest liczbowy
    if (item.added_to_pool && !isNaN(item.added_to_pool)) {
        totalAddedToPool += parseFloat(item.added_to_pool);
    }

      var memberDiv = $('<div>').text('#' + item.session_id + ', Added to Pool: ' + item.added_to_pool);
                joinedMembersDiv.append(memberDiv); 
});


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus, errorThrown);
        }
    });
}
function checkSessionId(currentSessionId) {
    $.ajax({
        method: 'GET',
        url: 'check_session_id.php',
        data: {
            session_id: currentSessionId
        },
        success: function (count) {
          console.log(count);
            if (count > 0) {
                $('#block_jackpot_joined').show();
            } else {
                $('#block_jackpot_joined').hide();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus, errorThrown);
        }
    });
}

checkSessionId(currentSessionId);
displayJoinedMembers();

    function ChangePanel() {
      $("#block_jackpot_joined").css({
        "display": "block"
      });
    }

    setInterval(function() {
      getPool();
      getPoolID();
      getBalance();
    }, 1000);

    function show_pool_join_panel() {
      $("#join_button").css({
        "display": "none"
      });
      $("#show_pool_join_panel").css({
        "display": "block"
      });
    }
function getMemberId(currentSessionId) {
    $.ajax({
        method: 'GET',
        url: 'get_member_id.php',
        data: {
            session_id: currentSessionId
        },
        success: function (_member_id) {
            member_id=_member_id;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus, errorThrown);
        }
    });
}

// Wywołanie funkcji z aktualnym session_id (zmień to na rzeczywisty session_id)
getMemberId(currentSessionId);
    function join_pool(session_id, member_id, pool, pool_id) {



$.ajax({
    method: 'POST',
    url: 'join_pool.php',
    data: {
        session_id: session_id,
        member_id: member_id,
        pool_id: pool_id,
        pool: pool
    },
    dataType: 'text',
    success: function(response) {
        setTimeout(function() {
            $.ajax({
              data: {
                session_id: session_id,
                pool_id: pool_id
              },
              type: 'GET',
              url: "check_pool_member.php",
              success: function(data) {
                ChangePanel();
              }
            });
          }, 500);
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error: " + textStatus, errorThrown);
    }
});

}

function join_pool_check() {
    var add_to_pool = $("#add_to_pool").val();

    if (add_to_pool <= member_balance) {
        var postData = {
            member_id: member,  // Hardcoded member_id for testing, replace with actual data
            pool_id: '1',   // Hardcoded pool_id for testing, replace with actual data
            pool: add_to_pool,
            session_id: currentSessionId
        };
console.log(currentSessionId);

        $.ajax({
            method: 'POST',
            url: 'join_pool.php',
            data: postData,
            success: function(response) {
                console.log(response);

                setTimeout(function() {
                    $.ajax({
                        data: {
                            session_id: postData.session_id,
                            pool_id: postData.pool_id
                        },
                        type: 'GET',
                        url: "check_pool_member.php",
                        success: function(data) {
                            console.log(data);
                            ChangePanel();
                            displayJoinedMembers();
                        }
                    });
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: " + textStatus, errorThrown);
            }
        });
    }
}
  </script>

</body>

<footer>

</footer>

</html>
