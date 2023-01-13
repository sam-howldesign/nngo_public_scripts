<!DOCTYPE html>
<html>
    <head>
        <title>Life Totaller</title>
        <style>
            .member {
                width: 18rem;
                display: flex;
                justify-content: space-between;
                margin-bottom: 0.5rem;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script>
            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            var total_life = 0;

            $(function(){
                $("#go_button").click(function(){
                    $("#member_list").html("");
                    total_life = 0;
                    $.ajax({
                        dataType: "json",
                        url: 'https://api.torn.com/faction/'+$("#faction_id").val()+'?selections=&key='+$("#torn_api").val(),
                    }).done(function(data){
                        $("#faction_name").html(data.name);
                        for (const memberId in data.members){
                            console.log(memberId);
                            console.log(data.members[memberId].name);
                            $("#member_list").append('<div class="member" data-id="'+memberId+'"><a target="_blank" href="https://www.torn.com/profiles.php?XID='+memberId+'">'+data.members[memberId].name+'</a> <span class="life">Fetching ...</span></div>');
                            getMemberLife(memberId);
                        }
                    });
                });                
            });
            function getMemberLife(memberId){
                sleep(1 * 1000);//sleep 1 second
                $.ajax({
                    dataType: "json",
                    url: 'https://api.torn.com/user/'+memberId+'?selections=&key='+$("#torn_api").val(),
                }).done(function(data){
                    total_life += data.life.maximum;
                    $("#faction_life").html(total_life);
                    $(".member[data-id='"+memberId+"'] .life").html(data.life.maximum);
                });
            }
        </script>
    </head>
    <body>
        <h1>NNGO Faction Life Totaler</h1>
        Your API key <input type="text" value="" id="torn_api" />(only minimal access needed)<br />
        Faction ID <input type="text" value="8811" id="faction_id" />(go to the faction page and look at the url)<br />
        <input type="button" value="Get it" id="go_button" ><br />
        <br />
        <br />
        Faction Name: <span id="faction_name"></span><br />
        Faction Total Life: <span id="faction_life"></span><br />
        Members:<br />
        <div id="member_list">
        </div>

    </body>
</html>