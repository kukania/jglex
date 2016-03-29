
        function makeDateToString(date) {
            var returnString = date.getFullYear() + "-";
            if ((date.getMonth() + 1) > 9)
                returnString += date.getMonth() + 1;
            else
                returnString += "0" + (date.getMonth() + 1);
            returnString += "-";
            if ((date.getDate()) > 9)
                returnString += date.getDate();
            else
                returnString += "0" + (date.getDate());
            return returnString;
        }
        //pm custom functions
        function pmHex2Rgba(rgb, alpha) {
            var r = parseInt(rgb.substring(1, 3), 16),
                g = parseInt(rgb.substring(3, 5), 16),
                b = parseInt(rgb.substring(5, 7), 16);
            return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')'
        }
        //<!--draw chart on canvas--
        
        function drawSetting() {//input 카테고리 선택
            var startDate = makeDateToString($("#datepicker").datepicker('getDate'));
            var endDate = makeDateToString($("#datepicker2").datepicker('getDate'));
            var inputOption = parseInt($("#optionHL").attr("value"))+1;
            var makeUrl = 'getCalcul.php?' + "date_from=" + startDate + "&date_to=" + endDate + "&option=" + inputOption;
            console.log(makeUrl);
            getDataFromServer(makeUrl);
        }
        function drawStart(inputArr) {
            var input;
            $(".cat").each(function (index, elem) {
                if ($(elem).attr("value") == 1) {
                    input = category[index];
                }
            })
            $("canvas").remove();
            $(".nodes").append('<canvas id="myChart" width="800px" height="500px"style="background-color:white">Your browser does not support the HTML5 canvas tag.</canvas>');
            var labels_week = []; // x축 표시
            var switchOption = $("#optionHL").attr("value");
            var startDate = new Date();
            startDate=$("#datepicker").datepicker("getDate");
            var endDate = new Date();
            endDate=$("#datepicker2").datepicker("getDate");
            switch (switchOption) {
                case "0":
                    var temp = startDate.getTime();
                    while (temp < parseInt(endDate.getTime()) + 1000 * 60 * 60 * 2) {
                        var pushString = "";
                        var tempDate = new Date(temp);
                        pushString += makeDateToString(tempDate);
                        labels_week.push(pushString);
                        temp += 1000 * 60 * 60 * 24;
                    }
                    break;
                case "1":
                    var temp = startDate.getTime();
                    while (temp < parseInt(endDate.getTime()) + 7 * 1000 * 60 * 60 * 2) {
                        var pushString = "";
                        var tempDate=new Date(temp);
                        pushString += tempDate.getWeek() + "week";
                        labels_week.push(pushString);
                        temp += 7 * 1000 * 60 * 60 * 24;
                    }
                    break;
                case "2":
                    var i = startDate.getMonth() + 1;
                    var end = endDate.getMonth()+(endDate.getFullYear()-startDate.getFullYear())*12;
                    for (i; i <= end;i++) {
                        var pushString = "";
                        var tempNum=(i%12!=0)?i%12:12;
                        pushString += tempNum + "~";
                        var temp = (tempNum + 1);
                        pushString += temp;
                        labels_week.push(pushString);
                    }
                    break;
                case "3":
                    var i = startDate.getFullYear();
                    var end = endDate.getFullYear();
                    for (i; i <= end; i++) {
                        var pushString = "";
                        pushString += i + "~";
                        var temp = (i + 1);
                        pushString += temp;
                        labels_week.push(pushString);
                    }
                    break;
                case "4":
                    var i = parseInt((startDate.getMonth())/3);
                    var end = parseInt((endDate.getMonth() + (endDate.getFullYear() - startDate.getFullYear()) * 12) / 3);
                    var tempYear = startDate.getFullYear()-1;
                    for (i; i <= end; i++) {
                        if (i % 4 == 0)
                            tempYear++;
                        var pushString = "" + tempYear + ".";
                        pushString += (i % 4+1);
                        labels_week.push(pushString);
                    }
                    break;
            }
            var labels_menu = [];//menu
            var containner = inputArr;
            for (var i = input[0]; i <= input[1]; i++) {
                labels_menu.push(MenuName["menu" + i]);
            }
            var ctx = document.getElementById("myChart").getContext("2d");
            var data = {
                labels: [],
                datasets: [],
            };
            /*
            input -> chicken etc....
            카테고리에 있는 목록마다 읽어와 현재 check 되어있는지 판단후 data 추가;
            */
            data.labels = labels_week;
            for (var i = input[0] - 1; i <= input[1] - 1; i++) {
                var tempNumBer = i - input[0] + 1;
                console.log(tempNumBer);
                //	var name = "menu" + (i+1);
                var color = color_list[i-input[0]+1];
                //	var data_temp = [];
                if (parseInt($(".filter").eq(tempNumBer).attr("value")) == 1)
                    var dataset = {
                        label: labels_menu[i],
                        fillColor: pmHex2Rgba(color, 0.0),
                        strokeColor: pmHex2Rgba(color, 1),
                        pointColor: pmHex2Rgba(color, 1),
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: pmHex2Rgba(color, 1),
                        data: containner[i]
                    }
                else
                    continue;
                data.datasets.push(dataset);
                //num++;
            }
            for (var key in data) {
                console.log(key + ":" + data[key]);
            }
            var option = {
                legendTemplate: '<ul>'
                      + '<% for (var i=0; i<datasets.length; i++) { %>'
                        + '<li>'
                        + '<span style=\"background-color:<%=datasets[i].lineColor%>\"></span>'
                        + '<% if (datasets[i].label) { %><%= datasets[i].label %><% } %>'
                      + '</li>'
                    + '<% } %>'
                  + '</ul>'
            };
            var myLineChart = new Chart(ctx).Line(data, option);
        }
        //<!--jquery ajax-->
        function getDataFromServer(inputURL) {
            var containner = [];
            $.ajax({
                type: "post",
                url: inputURL,
                dataType: "json",
                success: function (data) {
                    for (var key in data[0]) {
                        var temp = [];
                        for (var i in data) {
                            temp.push(data[i][key])
                        }
                        containner.push(temp);
                    }
                    drawStart(containner);
                },
                error: function (xhr, status, error) {
                    alert(error);
                }
            });
        }
        function load_ctgrlist(num) {
            $(".categorys").children(".cat").each(function (index, elem) {
                if (index == parseInt(num)) {
                    $(elem).attr("value", 1);
                }
                else {
                    $(elem).attr("value", 0);
                }

            })
			var filter_start = 	'<div class="filter" value="1">' +
								'<span class="filter_label">';
							// + menu_list[i]
			var filter_end = 	'</span></div>';
			var menu_list = [ "닭갈비 포장(생닭)",
             "닭갈비 포장(조리된)",
            "좋은 날엔 닭갈비",
            "닭갈비+1",
           "닭갈비 정식",
            "허브 치킨가스",
             "닭가슴살 냉채",
             "어린이 치킨가스",
             "모듬 사리",
             "우동 사리",
             "라면 사리",
             "떡 사리",
             "고구마 사리",
             "볶음밥",
             "공기밥",
             "양배추 샐러드",
             "소주/맥주",
             "막걸리",
             "청하",
             "음료수"];
			var color_list = ["#7fa742", "#3a7a8f", "#d21125", "#d97545", "#f5ef52", "#763aaf", "#55e1c5", "#6e4d1f"];
			var menu_count = [8, 5, 3, 4];
			var menu_offset = [0, 8, 17, 13];
			var filters_html = "";
			for(var i = 0; i < menu_count[num]; i++){
				filters_html +=	filter_start +
								menu_list[i+menu_offset[num]] +
								filter_end;
			}
			$("#category").html(filters_html);
			$('#category').css("border", "4px solid "+color_list[num]);
			$('#category').css("width", "220px");
			$(".filter").click(filter_toggle);
			$(".filter").each(function (index, elem) {
			    $(elem).css("backgroundColor", color_list[index]);
			});
			var show_tile = {
				duration: 100,
				start: function(){
					$(this).css("display", "flex");
					$(this).css("display", "-webkit-flex");
				}
			};
			$( ".filter" ).show(show_tile);
		}
		function filter_toggle(){
			var val = $(this).attr("value")
			var bcolor = $(this).css("background-color");
			var _color = $(this).css("color");
			if(val==1) val = 0;
			else val = 1;
			// $(this).animate({
			// 	opacity: 0.25,
			// 	backgroundColor: "rgb( 20, 20, 20 )",
			// 	color: "green"
			// 	}, 300);
			$(this).css("color", bcolor);
			$(this).css("backgroundColor", _color);
			$(this).attr("value", val);
		}
		function change_option(input) {
            $(".option").each(function (index, elem) {
                if (input == index) {
                    $(elem).css("backgroundColor", "#00beff");
                    $("#optionHL").attr("value", index);
                }
                else {
                    $(elem).css("backgroundColor", "#aaaeae");
                }
            });
        }
       