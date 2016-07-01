@extends('layout.master', ['title' => 'testMagicFunc'])

@section('topScript')
        <!-- MagicSuggest CSS -->
<link rel="stylesheet" href="css/magicsuggest-min.css">
<style></style>
@endsection

@section('content')
    @if (count($info_s) > 0)
        <ul>
            @foreach ($info_s as $info)
                <li>
                    Code <b>{{ $info->code }}</b> With <b>{{ $info->description }}</b>
                </li>
            @endforeach
        </ul>
    @endif

    <input id="magicsuggest" name="descriptions[]"/>
    <br/>
    <p id="test1"> Hi </p>
    <p id="test2"> Hi There </p>
    <button id="try">Click</button>
    <p id="getData"> Data here </p>
@endsection

@section('script')
    <!-- MagicSuggest JS -->
    <script src="js/magicsuggest-min.js"></script>
    <script>
        /*
        //Dummy data
        var datas = [
            { "id" : 1, "description" : "trying", "whatever" : "lol" },
            { "id" : 2, "description" : "again", "whatever" : "lol" }
        ];
        */
        $(function() {
            var Magic = $('#magicsuggest').magicSuggest({
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
