// set up our data series with 50 random data points

/*var seriesData = [ [], [], [] ];
var random = new Rickshaw.Fixtures.RandomData(20);

for (var i = 0; i < 110; i++) {
  random.addData(seriesData);
}*/

// instantiate our graph!

/*var graph = new Rickshaw.Graph( {
  element: document.getElementById("todaysales"),
  renderer: 'bar',
  series: [
    {
      color: "#33577B",
      data: seriesData[0],
      name: 'Photodune'
    }, {
      color: "#77BBFF",
      data: seriesData[1],
      name: 'Themeforest'
    }, {
      color: "#C1E0FF",
      data: seriesData[2],
      name: 'Codecanyon'
    }
  ]
} );*/

/*graph.render();

var hoverDetail = new Rickshaw.Graph.HoverDetail( {
  graph: graph,
  formatter: function(series, x, y) {
    var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
    var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
    var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
    return content;
  }
} );

//set up our data series with 50 random data points

var seriesData = [ [], [], [] ];
var random = new Rickshaw.Fixtures.RandomData(20);

for (var i = 0; i < 50; i++) {
  random.addData(seriesData);
}

// instantiate our graph!

var graph = new Rickshaw.Graph( {
  element: document.getElementById("todayactivity"),
  renderer: 'area',
  series: [
    {
      color: "#9A80B9",
      data: seriesData[0],
      name: 'London'
    }, {
      color: "#CDC0DC",
      data: seriesData[1],
      name: 'Tokyo'
    }
  ]
} );

graph.render();

var hoverDetail = new Rickshaw.Graph.HoverDetail( {
  graph: graph,
  formatter: function(series, x, y) {
    var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
    var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
    var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
    return content;
  }
} );*/

var $demo1 = $('table.table-fixed');
	$demo1.floatThead({
	scrollContainer: function($table){
		return $table.closest('.wrapper');
	}
});

$("#date-range201").datepicker({
	dateFormat:"dd/mm/yy",
});

$("#date-range200").datepicker({
	dateFormat:"dd/mm/yy",
	onSelect: function(dateText, inst) {
		var date = $(this).val();
		$("#date-range201").val(date);
	}
});

var showPopover = $.fn.popover.Constructor.prototype.show;
$.fn.popover.Constructor.prototype.show = function () {
	showPopover.call(this);
	if (this.options.showCallback) {
		this.options.showCallback.call(this);
	}
}

$("#PopS").popover({
	html: true,
	showCallback: function () {
		$("#datetimepicker1").datepicker({
			dateFormat:"dd/mm/yy",
		});

		$("#datetimepicker").datepicker({
			dateFormat:"dd/mm/yy",
			onSelect: function(dateText, inst) {
				var date = $(this).val();
				$("#datetimepicker1").val(date);
			}
		});

	}
});

$('#timeline').timestack({
  span: 'hour',
  data: [/*...*/],

	dateFormats: {                       //how to render times for various spans. These are moment formatting tokens.
		year: 'MMM YYYY',
		month: 'MMM DD',
		day: 'MMM DD',
		hour: 'HH:mm'
	  },

	  intervalFormats: {                   //how to render the intervals for various spans. These are moment formatting tokens.
		year: 'YYYY',
		month: 'MMM YYYY',
		day: 'MMM DD',
		hour: 'HH:mm'
	  }, 
});

/* Datepicker for Insert Google Form */
$(document).ready(function() {
  $('#date-picker').daterangepicker({
        singleDatePicker: true,
        format: 'M YYYY'
    }, function(start, end, label) {
  });
});

function ConfirmDelete(text = "Are you sure you want to delete this link?")
{
  var x = confirm(text);
  if (x)
	  return true;
  else
	return false;
}

// Get Variable From URL	
function getUrlVar(key) {
	var result 	=	new RegExp(key + "=([^&]*)", "i").exec(window.location.search);	
	return result && unescape(result[1]) || "";
}

$(document).ready(function(e) {
    var controller 	=	(getUrlVar('controller') == '' ) ? 'index' : getUrlVar('controller');
	var action 		=	(getUrlVar('action') == '' ) ? 'index' : getUrlVar('action');
	var classSelect 		=	controller + "-" + action;
	if(controller == 'group' && action == 'internal') {
		team 		=	(getUrlVar('action') == '' ) ? '' : getUrlVar('team');
		$("." + classSelect + " > ul").css("display", "block");
		$("." + classSelect + " > ul > li.team-"+ team + " > a").addClass('active');
	}
	$("#main-menu ul.nav li." + classSelect + " > a").addClass('active');
});

function removePersonalRow(url) {
	$.get(url, function(data){
		var idData 	=	data[0];
		var success = 	data[1];
		var x = confirm("Are you sure you want to delete this row ?");
		if(x == true) {
			if(success == 1) {
				$(".alert4.kode-alert").after('<div class="kode-alert kode-alert-icon kode-alert-click alert3"> <i class="fa fa-check"></i>This row is removed successfully !!</div>');
				$("tr#"+idData).remove();
			}
		} else {
			return false;
		}
		
		//
	}, 'json');
}