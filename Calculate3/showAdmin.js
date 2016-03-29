function makeTable() {
    $.ajax({
        type: "POST",
        url: "getMenu.php",
        dataType: "JSON",
        success: function (data) {
            var i = 1;
            for (var key in data) {
                $("#myTable").append("<tr></tr>");
                for (var key2 in data[key]) {
                    $("#myTable").children("tbody").children("tr").last().append("<td>" + data[key][key2] + "</td>");
                }
                $("#myTable").children("tbody").children("tr").last().append("<td><button onclick='edit(" + i + ");'>EDIT</button></td>");
                i++;
            }
            $("#myTable").append("<tr><td></td><td></td><td></td><td></td><td><button onclick='showAddMenu()'>메뉴추가</button></td></tr>");
        },
        error: function (xhr, status, error) {
            alert(error);
        }
    })
}
function deleteMenu(input) {
            $.ajax({
                type: "POST",
                url: "deleteMenu.php?num="+input.value,
                dataType: "JSON",
                success: function () {
                }
            });
            location.reload();
        }
function showAddMenu() {
            $("input[name='num']").val(parseInt($("#myTable").children("tbody").children("tr").last().prev().children("td").eq("0").html())+1);
            $("input[name='name']").val("");
            $("input[name='price']").val("");
            $("input[name='margin']").val("");
            $('#menu_edit').css('display', 'block');
            /*$('#menu_edit').animate(
                { height: '400px' },
                { duration: 400 }
            )*/
            $("#apply").attr("onclick", "addMenu();");
            $("#delete").attr("style", "display:none");
        }
function edit(input) {
            $("#delete").attr("style", "");
            input = parseInt(input);
            $.ajax({
                type: "POST",
                url: "getSelectMenu.php?num=" + input,
                dataType: "JSON",
                success: function (data) {
                    $("input[name='num']").val(data["num"]);
                    $("input[name='name']").val(data["name"]);
                    $("input[name='price']").val(data["price"]);
                    $("input[name='margin']").val(data["margin"]);
                    $("select").val(data["category"]);
                    $("form").children("#val").val(data["num"]);
                }
            });
            $('#menu_edit').attr("value", input );
            $('#menu_edit').css('display', 'block');
            /*$('#menu_edit').animate(
                { height: '400px' },
                { duration: 400 }
            )*/
            $("#delete").attr("value", input);
            $("#apply").attr("value", input);
            $("#apply").attr("onclick", "editMenu(this);");
        }
function addMenu() {
            var name_ = $("input[name='name']").val();
            var price_ = $("input[name='price']").val();
            var margin_ = $("input[name='margin']").val();
            var category_=$("select").val();
            var data_ = { name: name_, price: price_, margin: margin_,category:category_ };
            $.ajax({
                type: "POST",
                url: "addMenu.php",
                dataType: "JSON",
                data: data_,
            });
            location.reload();
        }
function editMenu(input) {
			alert(input.value);
            var name_ = $("input[name='name']").val();
            var price_ = $("input[name='price']").val();
            var margin_ = $("input[name='margin']").val();
            var category_=$("select").val();
            var data_ = { name: name_, price: price_, margin: margin_,category:category_ };
            $.ajax({
                type: "POST",
                url: "editMenu.php?num=" + input.value,
                dataType: "JSON",
                data:data_,
            });
            location.reload();
        }