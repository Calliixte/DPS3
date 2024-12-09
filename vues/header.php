<header>

    <nav id="quick-navbar">
        <a class="logo" href="test.html" >
            <img alt="logo" src="media/logo.svg" />
        </a>
        <a class="profilepic" href="test.html" >
            <img alt="profile picture" src="media/testpic.jpg" />
        </a>
        <a class="mypolls" href="test.html" >
            <img class="icon" alt="my polls" src="media/filled-poll-100.png" />
        </a>
        <a class="notifications" href="test.html" >
            <img class="icon" alt="notifications" src="media/filled-notification-100.png" />
        </a>
    </nav>
    
    <h2>MES COMMUNAUTÉS</h2>

    <div id="my-groups-top-grad"></div>
    <nav id="my-groups" class="hide-scrollbar">
        <?php
        foreach($utilisateur->get('listeGroupes') as $groupe){
            include('vues/boutonGroupe.php');
        }
        ?>
    </nav>
    <div id="my-groups-bottom-grad"></div>
    <div>
        <a class="group-button" href="#popup-add-group" >
            <img class="icon" alt="symbole plus" src="media/filled-add-group-100.png" />
            <p>Rejoindre un groupe</p>
        </a>
    </div>
    
</header>
