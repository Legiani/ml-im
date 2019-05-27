<!-- Show when JS is disable -->
<noscript>
    <style>
        .pagecontainer {display:none;}
        #nojsmsg{
            background-color: whitesmoke;
            width: 60%;
            height: 60%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: 20%;
            top: 20%;
        }
    </style>
    <div id="nojsmsg">
        <p><?php echo $web->getConf("pageDisableJS");?></p>
    </div>
</noscript>