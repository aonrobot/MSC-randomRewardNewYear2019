<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Metrosystems</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <style>
            .card {
                justify-content: center;
            }
            .card-img-top {
                width: 120px;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <div id="rewardPool">
                <div class="card-columns">
                </div>
            </div>
        </div>

        <script>

            function makeRewardUI(rewards) {
                var strCard = "";
                for (reward of rewards) {
                    strCard += `
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="https://cdn1.iconfinder.com/data/icons/present-4/64/gift-bow-present-surprise-512.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">${reward.RewardDesc}</h5>
                            <p class="card-text">จำนวน ${reward.Qty} รางวัล</p>
                            <a href="/newyear2019/random?quantity=${reward.Qty}&rewardName=${reward.RewardDesc}" target="_blank" class="btn btn-primary">จับรางวัล</a>
                        </div>
                    </div>
                    `;
                }
                $('#rewardPool > .card-columns').append(strCard);
            }

            $(document).ready(function(){
                $.ajax({
                    url : "getListReward",
                    type : "get",
                    async: false,
                    success : function(result) {
                        makeRewardUI(result)
                        console.log(result)
                    },
                    error: function() {
                        alert('server cannot load');
                    }
                });
            });
            
        </script>
    </body>
</html>
