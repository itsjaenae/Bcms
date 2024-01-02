<div class="container">
    <a href="bus_ticket">
    <h2 class="center tm-text tm_head">Top Bus Destinations</h2>
    </a>
    <?php
         $query = "select * from bus_route limit 8";
        $rows = dbConnect($query);   ?>
           
                <div class="row ">
                <?php if (!empty($rows)) : ?>
                    <?php foreach ($rows as $row) :  ?>
                    <div class="col-xs-12 col-sm-6 tm-article">
                        <div class="box_box" style="margin-bottom:  -1rem;">
                            <p style="font-weight: 700;font-size: 0.9rem; color: #333">Bus from <?=$row['departure'] ?>
                            to
                            <?=$row['destination'] ?>
                        </P>
                        </div>
                    </div>
                    <?php endforeach; ?> 
                     <?php endif; ?>  
                </div>
            </div>

   