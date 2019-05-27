$(function () {
  var from,
      to,
      day,
      isMouseDown = false,
      bgDanger,
      bgWarning,
      isHighlighted,
      column = 1;



  $("#calendar th").each(function () {

    var data = program.filter(x => x.day === column);
    var warning = data.filter(x => x.color === "reser");
    var danger = data.filter(x => x.color === "teach");

    $("#calendar tr").each(function () {
      var time = $(this).closest('tr').find('td:eq(0)').text();
      index = $(this).index()+2;
      var timePlasOne = $("#calendar").find('tr:eq('+index+')').find('td:eq(0)').text();
      var cell = $(this).closest('tr').find('td:eq('+column+')');

      var wIndex = warning.findIndex(function(item, i){
        return item.from === time
      });
      var dIndex = danger.findIndex(function(item, i){
        return item.from === time
      });

      if(wIndex >= 0){
        bgWarning = "bg-warning";
      };
      if(dIndex >= 0){
        bgDanger = "bg-danger";
      };


      if(bgWarning != undefined){
        if(bgDanger != undefined){
          cell.toggleClass(bgDanger);
        }else{
          cell.toggleClass(bgWarning);
        }
      }

      var wIndex = warning.findIndex(function(item, i){
        return item.to === timePlasOne
      });
      var dIndex = danger.findIndex(function(item, i){
        return item.to === timePlasOne
      });

      if(dIndex >= 0){
        bgDanger = undefined;
      };
      if(wIndex >= 0){
        bgWarning = undefined;
      };

    })
    column = column+1;
  })

  $("#calendar td")

    .mousedown(function () {
      isMouseDown = true;
      $(this).toggleClass("bg-secondary");
      isHighlighted = $(this).hasClass("bg-secondary");
      
      day = $('#calendar th').eq($(this).index()).data("id");
      from = $(this).closest('tr').find('td:eq(0)').text();

      return false; // prevent text selection
    })
    .mouseover(function () {
      if (isMouseDown && day == $('#calendar th').eq($(this).index()).data("id")) {
        $(this).toggleClass("bg-secondary", isHighlighted);
      }
    })
    .bind("selectstart", function () {
      return false;
    })
    .mouseup(function () {
      isMouseDown = false;
      index = $(this).parent().index()+2;
      to = $("#calendar").find('tr:eq('+index+')').find('td:eq(0)').text();

      var dateDay = day.split("/").map(Number);
      $('#exampleModal').modal('show');
      $('#dateDay').datetimepicker({
        format: 'Y/M/D',
        defaultDate: moment({
          year: dateDay[0],
          month: dateDay[1]-1,
          day: dateDay[2]

        })
      });
      var timeFrom = from.split(":").map(Number);
      $('#timeFrom').datetimepicker({
        format: 'H:mm',
        defaultDate: moment({
          hour: timeFrom[0],
          minutes: timeFrom[1]
        })
      });
      var timeTo = to.split(":").map(Number);
      $('#timeTo').datetimepicker({
        format: 'H:mm',
        defaultDate: moment({
          hour: timeTo[0],
          minutes: timeTo[1]
        })
      });
      //$('#data').text(day+"  "+from +"  "+to);
      
    })




});