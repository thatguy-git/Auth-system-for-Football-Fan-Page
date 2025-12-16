<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="./css/output.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body class="">
    <div class="bg-red-600 w-full pt-4 pb-2 shadow-md">
    
    <div class="container mx-auto px-6 flex flex-row items-center justify-between mb-4">
        
        <div class="flex items-center">
            <img src="images/vecteezy_liverpool-club-symbol-white-logo-premier-league-football_26135426-removebg-preview.png" 
                    alt="Liverpool Logo" 
                    class="h-20 w-auto object-contain"> 
        </div>

        <div class="text-center mx-4">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-widest uppercase font-sans">
                The Liverpool Offside
            </h1>
        </div>

        <div class="flex items-center space-x-4">
            <a href="login.php" class="text-white font-semibold hover:text-red-200 transition">
                Login
            </a>
            <a href="signup.php" class="bg-white text-red-600 font-bold py-2 px-5 rounded-sm hover:bg-gray-100 transition shadow-lg">
                Signup
            </a>
        </div>
    </div>

    <div class="border-t border-white opacity-50 mx-6"></div>

    <div class="flex text-white justify-center space-x-10 font-bold py-3 text-sm tracking-wide">
        <a href="#" class="hover:text-red-200 transition relative group">
            THE FEED
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all group-hover:w-full"></span>
        </a>
        <a href="#" class="hover:text-red-200 transition relative group">
            SECTIONS
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all group-hover:w-full"></span>
        </a>
        <a href="#" class="hover:text-red-200 transition relative group">
            LIBRARY
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all group-hover:w-full"></span>
        </a>
        <a href="#" class="hover:text-red-200 transition relative group">
            ABOUT
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all group-hover:w-full"></span>
        </a>
    </div>
</div>
    <div class="bg-gray-100 min-h-screen pb-12">
        
        <div class="container mx-auto px-4 py-10">
            <div class="bg-white rounded-sm shadow-xl overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-2/3 h-64 md:h-auto relative">
                    <img src="images/liverpools-team.jpg" 
                            alt="Matchday" 
                            class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 bg-red-600 text-white text-xs font-bold px-3 py-1 uppercase tracking-widest">
                        Match Recap
                    </div>
                </div>
                
                <div class="md:w-1/3 p-8 flex flex-col justify-center">
                    <h2 class="text-gray-500 font-bold tracking-widest text-xs mb-2 uppercase">Premier League</h2>
                    <h1 class="text-3xl font-extrabold font-sans text-gray-900 leading-tight mb-4 hover:text-red-600 transition duration-300 cursor-pointer">
                        Dominant Display: Reds Crush Rivals in Anfield Thriller
                    </h1>
                    <p class="text-gray-600 mb-6">
                        Salah and Ekitike were on target as Liverpool secured a vital three points to stay top of the table. Read our full analysis of the tactical masterclass.
                    </p>
                    <a href="#" class="inline-block bg-red-600 text-white font-bold py-3 px-6 rounded-sm hover:bg-red-700 transition duration-300 text-center uppercase tracking-wide">
                        Read Full Story
                    </a>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-l-4 border-red-600 pl-4">
                LATEST HEADLINES
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white rounded-sm shadow-md overflow-hidden hover:shadow-xl transition duration-300 group hover:cursor-pointer">
                    <div class="h-48 overflow-hidden">
                        <img src="images/liverpool3.jpg" alt="News" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6">
                        <span class="text-red-600 font-bold text-xs uppercase">Transfers</span>
                        <h4 class="font-bold text-xl mt-2 mb-2 group-hover:text-red-600">Pack it up buddy </h4>
                        <p class="text-gray-600 text-sm">Good thing Salah is muslim he'd fit in well in teh Saudi Pro League.</p>
                    </div>
                </div>

                <div class="bg-white rounded-sm shadow-md overflow-hidden hover:shadow-xl transition duration-300 group hover:cursor-pointer">
                    <div class="h-48 overflow-hidden">
                        <img src="images/nunez.jpg" alt="News" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6">
                        <span class="text-red-700 font-bold text-xs uppercase">Quotes</span>
                        <h4 class="font-bold text-xl mt-2 mb-2 group-hover:text-red-600">"We Must Be Ready to Fight"</h4>
                        <p class="text-gray-600 text-sm">The boss speaks ahead of the crucial Champions League tie against Madrid.</p>
                    </div>
                </div>

                <div class="bg-white rounded-sm shadow-md overflow-hidden hover:shadow-xl transition duration-300 group hover:cursor-pointer">
                    <div class="h-48 overflow-hidden">
                        <img src="images/player2.jpg" alt="News" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6">
                        <span class="text-red-600 font-bold text-xs uppercase">Injury Update</span>
                        <h4 class="font-bold text-xl mt-2 mb-2 group-hover:text-red-700">Trent Return Date Set</h4>
                        <p class="text-gray-600 text-sm">Good news from the training ground as the vice-captain returns to team drills.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <footer class="bg-red-600 text-white py-10 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="font-bold text-lg mb-2">THE LIVERPOOL OFFSIDE</p>
            <p class="text-gray-500 text-sm">Built by thatguy. YNWA.</p>
        </div>
    </footer>
    
</body>
</html>
