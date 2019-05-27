
                    <div class="p-2 bg-light d-flex my-auto">
                        <div class="col-md-4">
                            <?php
                                if($teacher['sex'] == "m"){
                                    echo '<i class="fas fa-male fa-2x"></i> <p>Můž</p>';
                                }else{
                                    echo '<i class="fas fa-female fa-2x"></i> <p>Žena</p>';
                                }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                            <?php
                                echo '<p>'.$teacher["city"]."</p>";
                            ?>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-clock fa-2x"></i>
                            <p>0</p>
                        </div>
                    </div>
                    <div class="mt-3 p-2 bg-light">
                        <h3><?php echo $web->getConf("detailAbout");?></h3>
                        <p><?php echo $teacher["about"];?><p>
                    </div>
                    <div class="mt-3 p-2 bg-light">
                        <h3><?php echo $web->getConf("detailKeywords");?></h3>
                        <?php
                            foreach($tags as $tag){
                                
                                echo '<a href="/?tag='.$tag["tag"].'"><span class="badge badge-info m-2">'.$tag["tag"].'</span></a>';
                            }
                        ?>
                    </div>
                    <div class="mt-3 p-2 bg-light">
                        <h3><?php echo $web->getConf("detailLanguage");?></h3>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                <th scope="col"></th>
                                <th scope="col">Jazyk</th>
                                <th scope="col">Uroven</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($langs as $key => $lang){
                                    echo '<tr>
                                        <th scope="row"><img src="/assets/img/flag/'.$lang["lang"].'.png" class="img-fluid" alt="flag"></th>
                                        <td>'.$lang["lang"].'</td>
                                        <td>'.$lang["levl"].'</td>
                                    </tr>
                                    ';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 p-2 bg-light">
                        <h3><?php echo $web->getConf("detailReview");?></h3>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                <th scope="col">Od</th>
                                <th scope="col">Hodina</th>
                                <th scope="col">Komentář</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                
                                    echo '<tr>
                                        <th scope="row">Honza Nevím</th>
                                        <td>22.3.2019 13:00-16:00</td>
                                        <td>Lorem ipsum (zkráceně lipsum) je označení pro standardní pseudolatinský text užívaný v grafickém designu a navrhování jako demonstrativní výplňový text při vytváření pracovních ukázek grafických návrhů (např. internetových stránek, rozvržení časopisů či všech druhů reklamních materiálů).</td>
                                    ';
                            ?>

                                            <td>
                                                <span class="fa fa-star text-warning"></span>
                                                <span class="fa fa-star text-warning"></span>
                                                <span class="fa fa-star text-warning"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            <td>
                                            </tr>
                            </tbody>
                        </table>
                    </div>
 