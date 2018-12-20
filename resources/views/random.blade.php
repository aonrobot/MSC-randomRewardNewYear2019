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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <style>
            .card {
                justify-content: center;
            }
            .card-columns .card {
                text-align: center;
            }
            .card-columns {
                column-count: 3;
            }
            .card-img-top {
                width: 120px;
                margin-left: auto;
                margin-right: auto;
            }
            .jumbotron {
                padding: 1rem;
            }
            .circle {
                height: 200px;
                width: 200px;
                border-radius: 500px;
                font-size: 36px;
            }
        </style>
    </head>
    <body>
        <div class="text-center mt-5">
            <h1 id="rewardLabel"></h1>
        </div>
        <div class="container-fluid mt-2">
                People Pool <span class="badge badge-primary" id="poolAvailableLabel"></span>
            <div class="jumbotron">
                <div class="col-sm-12 text-center">
                    <button class="btn btn-danger btn-lg circle" href="#" role="button" id="randomBtn"><i class="fas fa-random"></i><br>Random</button>
                </div>
                <div class="col-sm-12 text-right">
                    <a class="btn btn-light btn-lg" href="#" role="button" id="resetBtn" style="font-size:10px">Reset Pool</a>
                </div>
            </div>
            <div id="peoplePool">
                <div class="card-columns">
                </div>
            </div>
        </div>

        <script>

            function getURLParameter(name) {
                return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
            }

            function checkFirstLoadPeople() {
                firstLoad = localStorage.getItem("firstLoad");
                console.log('first load? ', firstLoad);
                if (firstLoad == undefined || firstLoad == "true") {
                    // $.get('getListPeople', function (result) {
                    //     localStorage.setItem("peoplePool", JSON.stringify(result.slice(0, 5)));
                    //     localStorage.setItem("firstLoad", "false");
                    // });

                    $.ajax({
                        url : "getListPeople",
                        type : "get",
                        async: false,
                        success : function(result) {
                            localStorage.setItem("peoplePool", JSON.stringify(result));
                            localStorage.setItem("firstLoad", "false");
                        },
                        error: function() {
                            alert('server cannot load');
                        }
                    });
                    
                } else {
                    return JSON.parse(localStorage.getItem("peoplePool"));
                }
            }

            function updatePeopleLabel(value) {
                $('#poolAvailableLabel').html(value);
            }

            function makePeoplePoolUI(people) {
                var strCard = "";
                for (p of people.slice(0, 5)) {
                    var imageNo = p.No % 20;
                    strCard += `
                        <div class="card">
                            <!--<img class="card-img-top" src="image/avatar/${imageNo}.png" alt="Card image cap">-->
                            <div class="card-body">
                                <h5 class="card-title text-center">${p.EmpName} ${p.EmpLastName}</h5>
                            </div>
                        </div>
                    `;
                }
                $('#peoplePool > .card-columns').append(strCard);
            }
            
            function makePeopleUI(people) {
                var strCard = "";
                for (index in people)
                {                  
                    var imageNo = people[index].No % 20;
                    $('#peoplePool > .card-columns').append(`
                        <div class="card" id="people${people[index].No}" style="display:none">
                            <div class="card-body">
                                <h5 class="card-title text-center">${people[index].EmpName} ${people[index].EmpLastName}</h5>
                            </div>
                        </div>
                    `);
                }
                makePeopleEffect(people)
            }

            var makePeopleEffect_index = 0;
            function makePeopleEffect (people) { 
                setTimeout(function () {
                    $(`#people${people[makePeopleEffect_index].No}`).fadeIn()

                    makePeopleEffect_index++;
                    if (makePeopleEffect_index < people.length) {
                        makePeopleEffect(people);             
                    }                     
                }, 1200)
            }

            quantity = getURLParameter('quantity');
            rewardName = getURLParameter('rewardName');
            
            checkFirstLoadPeople()
            peoplePool = JSON.parse(localStorage.getItem("peoplePool"));
            updatePeopleLabel(peoplePool.length)
            //if (peoplePool == null) location.reload(false);
            console.log('peoplePool', peoplePool);
            
            var randomPeople = [];
            $(document).ready(function(){
                $('#randomBtn').click(function() {
                    $('#randomBtn').prop('disabled', true);
                    if(quantity !== null) {
                        var randomIndex = []; // TODO: Incress random performance
                        for (i = 0; i < quantity; i++)
                        {
                            if (peoplePool.length == 0)
                            {
                                console.log('empty pool');
                                break;
                            }
                            randomNumber = Math.floor(Math.random() * peoplePool.length);
                            randomPeople.push(peoplePool[randomNumber]);
                            peoplePool.splice(randomNumber, 1);
                            updatePeopleLabel(peoplePool.length)

                            localStorage.setItem("peoplePool", JSON.stringify(peoplePool));
                        }
                        makePeopleUI(randomPeople);
                    } else {
                        alert('please back to select gift');
                    }
                });

                $('#resetBtn').click(function() {
                    // TODO: Sdd confirm by type 'reset'
                    localStorage.removeItem("peoplePool");
                    localStorage.setItem("firstLoad", "true");
                    location.reload(1);
                })

                if (rewardName != undefined) 
                    $('#rewardLabel').html(`${rewardName} <span class="badge badge-primary">จำนวน ${quantity} รางวัล</span>`);
            });
            
        </script>
    </body>
</html>
