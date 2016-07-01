@extends('layout.master', ['title' => 'tBalForm'])

@section('topScript')
    <!-- JSGrid -->
    <!--
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid-theme.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.js"></script>
    -->
    <link type="text/css" rel="stylesheet" href="css/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="css/jsgrid-theme.min.css" />
    <script type="text/javascript" src="js/jsgrid.min.js"></script>

    <!-- MagicSuggest -->
    <link rel="stylesheet" href="css/magicsuggest-min.css">
    <script src="js/magicsuggest-min.js"></script>
@endsection

@section('css')
@endsection

@section('content')
    <!-- ==Solution for POST error 500 (Part 1)== -START- -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- -END- -->
    <div id="jsGrid">
    </div>
@endsection

@section('script')
    <script>
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
            //========Fast Data Entry START========
            $(".JSGridInsertHeader input").click();
            $(".JSGridYear input").focus();
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
            //========Fast Data Entry END========

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

            var Magic = $('.JSGridCOA input').magicSuggest({
                allowFreeEntries: false,
                maxSelection: 1,
                hideTrigger: true,

                //might be useful
                //id: 'custom-id-name', //so that can retrieve its properties/methods/events after component created
                //typeDelay: 0, //so that wun keep send AJAX for every query (will have delay)
                //maxDropHeight: 145,   //limit the 'combobox' height
                //maxSuggestions: 5,    //limit the number of records displayed at a time?
                //name: 'coa',  //so that its value will be passed along with other form components to the server?

                useZebraStyle: true,
                minChars: 1,    //using now to check easier
                noSuggestionText: 'No COA found',
                placeholder: 'Enter COA',
                //strictSuggest: true, //no longer useful since using mode:'remote'?
                //mode: 'remote', //changes the filter

                //data: {!! $info_s !!},
                //data: 'testMData.php',
                data: function(q) {
                    var e = q || '',r=[];
                    //var c=['Paris', 'New York', 'Gotham'];
                    var c = {"data1": {!! $info_s !!} };
                    //var chars = q.length || 0;
                    /*
                    do {
                        chars
                    } while (chars > 2);
                    */
                    for(var i=0; i< c.data1.length; i++) {
                        //if(c.data1[i].code.toLowerCase().indexOf(e.toLowerCase()) > -1)
                            r.push({id: i, code: c.data1[i].code, description: c.data1[i].description, crdr: c.data1[i].crdr})
                    }
                    return r;
                },

                valueField: 'code',  //which is what will get when MagicSuggest.getValue()

                displayField: 'code',
                /*renderer: function(data){   //aka display for combobox;  advance version of 'displayField'?
                    return '<div class="codeDisp">' +
                    data.code + '</div>' +
                    '<div class="descDisp">' +
                    data.description + '</div>';
                    },
                */
                selectionRenderer: function(data){  //aka display after selected
                    return data.code;
                }
            });

            $(Magic).on('selectionchange', function() {
                //$("#getData").text(JSON.stringify(Magic.getData()));  //something like getSelection(),
                //but retrieves THE WHOLE JSON of the data (instead of the selected record)
                //$("#getData").text(JSON.stringify(Magic.getSelection()));   //something like getValue(),
                //but retrieves all the related JSON of the selected record
                var text1 = Magic.getSelection();
                var text2 = text1[0].description;
                var text3 = text1[0].crdr;
                $(".JSGridDesc input").val(text2);
                $(".JSGridCrDr select option:first").val(text3).html(text3);
            });

            var Num = 1;
            $(Magic).on('selectionchange', function(e,m) {
                $("#test1").text(this.getValue());
                Num++;
            });
            $('#try').on('click', function(e,m) {
                if ($("#test1").text() == "Asset") {
                    $("#test2").text("It is Asset");
                } else {
                    $("#test2").text("Not Asset");
                }
            });
        });
    </script>
@endsection