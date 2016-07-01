@extends('layout.master', ['title' => 'testTable2'])

@section('topScript')
    <!--
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid-theme.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.js"></script>
    -->
    <link type="text/css" rel="stylesheet" href="css/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="css/jsgrid-theme.min.css" />
    <script type="text/javascript" src="js/jsgrid.min.js"></script>
@endsection

@section('css')
    <style>
        .JSGridInsertHeader {

        }
        .JSGridYear, .JSGridCOA, .JSGridAmount {
            color: red;
        }
        .JSGrids {
            color: blue;
        }
    </style>
@endsection

@section('content')
    <!-- ==Solution for POST error 500 (Part 1)== -START- -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- -END- -->
    {!! $info_s !!}
    <p id="test1"> Hi </p>
    <div id="jsGrid">
    </div>
    <input id="hi" type="text" />
@endsection

@section('script')
    <script>
        var tBalData = [
            { "id": "2000", "code": "1234", "description" : "->Buildings", "crdr" : 1, "Amount" : "10" },
            { "id": "2001", "code": "1234", "description" : "->Buildings", "crdr" : 2, "Amount" : "100" }
        ];
        var accType = [
            { "DisplayName": "(none)", "DBName": "" },
            { "DisplayName": "Credit~", "DBName": "Credit" },
            { "DisplayName": "Debit~", "DBName": "Debit" }
        ];

        $(document).ready(function() {

            // ==Solution for POST error 500 (Part 2)== -START-
            // ... missing CSRF (middleware feature?)...
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            //-END-

            $("#jsGrid").jsGrid({
                width: "100%",
                height: "100%",

                filtering: false,
                editing: true,
                inserting: true,
                sorting: true,
                paging: true,
                autoload: true,

                pageSize: 10,
                pageButtonCount: 2,

                deleteConfirm: "Really Delete?",
                //data: {!! $info_s !!},
                //data: tBalData,
                //data: 'testTData.php',
                controller: {
                    loadData: function(filter) {
                        return $.ajax({
                            type: "GET",
                            url: "/testTData",
                            data: filter,
                            dataType: "json"
                        });
                    },
                    insertItem: function(item) {
                        return $.ajax({
                            type: "POST",
                            url: "/testTData",
                            data: item,
                            dataType: "json"
                        });
                    },
                    updateItem: function(item) {
                        return $.ajax({
                            type: "PUT",
                            url: "/testTData",
                            data: item,
                            dataType: "json"
                        });
                    },
                    deleteItem: function(item) {
                        return $.ajax({
                            type: "DELETE",
                            url: "/testTData",
                            data: item,
                            dataType: "json"
                        });
                    }
                },
                fields: [
                    { insertcss: "JSGridYear JSGrids", name: "year", title: "Years", type: "number", width: 25 },
                    { insertcss: "JSGridCOA JSGrids", name: "coa", title: "COA", type: "number", width: 25 },
                    { name: "description", title: "Description", type: "text", readOnly: true},
                    { name: "crdr", title: "Credit/Debit", type: "select", items: accType, valueField: "DBName", textField: "DisplayName", width: 25, readOnly: true },
                    { insertcss: "JSGridAmount JSGrids", name: "amount", title: "Amount", type: "number", width: 25 },
                    { headercss: "JSGridInsertHeader", insertcss: "JSGridInsert", type: "control", width: 25 }
                ],
                /*
                RowRenderer: function(item) {
                    return $("<tr>").addClass("custom-row")
                            .append($("<td>").append("Year"))   //.append($("<td>").append(item.year))
                            .append($("<td>").append(item.code))
                            .append($("<td>").append(item.description))
                            .append($("<td>").append(item.crdr))
                            .append($("<td>").append("Amount"));    //.append($("<td>").append(item.amount));
                }
                */
            });

            /*
            //Create an id for each of the header inputbox
            $(".JSGrids").each(function (index, value) {
               $(this).attr('id', 'abc'+index);
            });
            $("#abc0").keyup(function (e) {
                var keyCode = (e.keyCode ? e.keyCode : e.which);
                if (keyCode == 13) {
                    $("#abc1 input").focus();
                }
            });
            */
            $(".JSGridInsertHeader input").click();
            $(".JSGridYear input").focus();

            //========Fast Data Entry 2 START========
            //Method 1
            var JSGridYearValue = 0;
            $(document).ajaxComplete(function(event, requests, settings) {
                //if (JSGridYearValue != 0) {   //should be not necessary anymore since checking the settings.type
                if (settings.type == 'POST') {
                    $(".JSGridYear input").val(JSGridYearValue);
                    $(".JSGridCOA input").focus();
                }
            });
            //Method 2: Not working
            /*
            $(document).on('click', '.JSGridInsert', function () {
                $(".JSGridYear input").val(JSGridYearValue);
                $(".JSGridCOA input").focus();
            });
            */
            //========Fast Data Entry 2 END========

            $(document).on('keydown', '.JSGridYear', function (e) {
                var keyCode = (e.keyCode ? e.keyCode : e.which);
                if (keyCode == 13) {
                    var own = $(this).children('input');    //var own = $(".JSGridYear input");
                    if ( own.val() == "") {
                        own.focus();
                    } else {
                        JSGridYearValue = own.val();
                        $(".JSGridCOA input").focus();
                    }
                }
            }).on('keydown', '.JSGridCOA', function (e) {
                    var keyCode = (e.keyCode ? e.keyCode : e.which);
                if (keyCode == 13) {
                    var own = $(this).children('input');
                    var other = $(".JSGridAmount input");
                    if (( other.val() == "") || ( own.val() == "")) {
                        other.focus();
                    } else {
                        $('.JSGridInsert input').click();
                    }
                }
            }).on('keydown', '.JSGridAmount', function (e) {
                var keyCode = (e.keyCode ? e.keyCode : e.which);
                if (keyCode == 13) {
                    var own = $(this).children('input');
                    var other = $(".JSGridCOA input");
                    if (( other.val() == "") || ( own.val() == "")) {
                        other.focus();
                    } else {
                        $('.JSGridInsert input').click();
                    }
                }
            });
            /*
            $(".JSGridYear").keydown(function (e) {
                var keyCode = (e.keyCode ? e.keyCode : e.which);
                if (keyCode == 13) {
                    var own = $(".JSGridYear input");
                    if ( own.val() == "") {
                        own.focus();
                    } else {
                        $(".JSGridCOA input").focus();
                    }
                }
            });
            */
        });

    </script>
@endsection