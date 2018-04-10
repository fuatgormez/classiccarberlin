<?php
//========================================================================================================
    require_once 'case.inc.php';
//========================================================================================================

$_POST      = multiDimensionalArrayMap('cleanEvilTags', $_POST);
$_POST      = multiDimensionalArrayMap('cleanData', $_POST);

$_GET       = multiDimensionalArrayMap('cleanEvilTags', $_GET);
$_GET       = multiDimensionalArrayMap('cleanData', $_GET);

$_FILES     = multiDimensionalArrayMap('cleanEvilTags', $_FILES);
$_FILES     = multiDimensionalArrayMap('cleanData', $_FILES);

$_SESSION   = multiDimensionalArrayMap('cleanEvilTags', $_SESSION);
$_SESSION   = multiDimensionalArrayMap('cleanData', $_SESSION);

$_COOKIE    = multiDimensionalArrayMap('cleanEvilTags', $_COOKIE);
$_COOKIE    = multiDimensionalArrayMap('cleanData', $_COOKIE);
//========================================================================================================
#Date Format
if (@$_SESSION['lang'] == NULL || $_SESSION['lang'] ==='de'){
    setlocale(LC_TIME, 'de_DE.UTF-8');
}elseif ($_SESSION['lang'] ==='tr'){
    setlocale(LC_TIME, 'tr_TR.UTF-8');
}elseif ($_SESSION['lang'] ==='en'){
    setlocale(LC_TIME, 'en_EN.UTF-8');
}
//========================================================================================================
	function Meta(){
		//$do = g("do");
        @$do = $_GET['do'];
		Switch ($do){
			case "Seite":
			require_once THEME."/Siete.php";
			break;
			default:
			$title = ss(SITE_TITLE);
			$desc  = ss(SITE_DESC);
			$keyw  = ss(SITE_KEYW);
			break;
		}
		echo '<title>'.SITE_TITLE.'</title>
		<meta name="description" content="'.$desc.'" />
		<meta name="keywords" content="'.$keyw.'" />';
	}
//========================================================================================================

//========================================================================================================
	function Slider(){
        $db = new Database();
        $SliderBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_SLIDER WHERE DURUM = 0");
        foreach ($SliderBul AS $SliderGoster){
            if($SliderGoster["VIDEO"] !=''){
                echo'<div class="swiper-slide dark">
                <div class="video-wrap">
                    <video poster="uploads/slider/'.$SliderGoster["RESIM"].'" preload="auto" loop autoplay muted>
                        <source src="uploads/videolar/'.$SliderGoster["VIDEO"].'" type="video/mp4"" />
                        <source src="uploads/videolar/'.$SliderGoster["VIDEO"].'" type="video/webm" />
                    </video>
                    <div class="video-overlay" style="background-color: rgba(0,0,0,0.55);"></div>
                </div>
                <div class="container clearfix">
                    <div class="slider-caption slider-caption-center">
                        <h2 data-caption-animate="fadeInUp">'.$SliderGoster["MAINTITLE"].'</h2>
                        <p data-caption-animate="fadeInUp" data-caption-delay="200">'.$SliderGoster["BIGTITLE"].'</p>
                        <p data-caption-animate="fadeInUp" data-caption-delay="200">'.$SliderGoster["SMALLTITLE"].'</p>
                    </div>
                </div>
            </div>';
            }else{
                echo'<div class="swiper-slide dark" style="background-image: url(uploads/slider/'.$SliderGoster["RESIM"].');">
                <div class="container clearfix">
                    <div class="slider-caption slider-caption-center">
                        <h2 data-caption-animate="fadeInUp">'.$SliderGoster["MAINTITLE"].'</h2>
                        <p data-caption-animate="fadeInUp" data-caption-delay="200">'.$SliderGoster["BIGTITLE"].'</p>
                        <p data-caption-animate="fadeInUp" data-caption-delay="200">'.$SliderGoster["SMALLTITLE"].'</p>
                    </div>
                </div>
            </div>';
            }
        }
	}
//========================================================================================================
	function Personel($Limit = 4){
		$db = new Database();
		$PersonelBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_PERSONEL ORDER BY ID DESC LIMIT $Limit");
		if (count($PersonelBul) != NULL ){
			foreach ($PersonelBul as $PersonelGoster){

				echo '<div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img width="150" height="200" src="uploads/personel/'.$PersonelGoster['RESIM'].'" alt="'.$PersonelGoster['ADSOYAD'].'">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>'.$PersonelGoster['ADSOYAD'].'</h4><span>'.$PersonelGoster['GOREVI'].'</span></div>
                                <a href="https://facebook.com/'.$PersonelGoster['FACEBOOK'].'" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="https://twitter.com/'.$PersonelGoster['TWITTER'].'" class="social-icon inline-block si-small si-light si-rounded si-twitter">
                                    <i class="icon-twitter"></i>
                                    <i class="icon-twitter"></i>
                                </a>
                                <a href="mailto:'.$PersonelGoster['EPOSTA'].'" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email"></i>
                                    <i class="icon-email"></i>
                                </a>
                            </div>
                        </div>

                    </div>';
			}
		}else {
			echo "Personel eklenmemiş!";
		}
		$db->Disconnect();
	}
//========================================================================================================
	function Ipucu($limit = 1){
		$db = new Database();
		$IpucuBul = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_IPUCU ORDER BY RAND() DESC LIMIT $limit");
            if($IpucuBul !=''){
				$Mesaj = html_entity_decode($IpucuBul["MESAJ"]);
                echo $Mesaj;
		}else {
			return false;
		}
		$db->Disconnect();
	}
//========================================================================================================
	function Isler($limit = 4){
		$db = new Database();
		$IsBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_ISLER INNER JOIN ".TABLO_ONEKI."TBL_RESIMLER ON ".TABLO_ONEKI."TBL_RESIMLER.ISID = ".TABLO_ONEKI."TBL_ISLER.ID LIMIT $limit");
		if(count($IsBul) != NULL){
		foreach ($IsBul as $IsGoster) {
			echo'<div class="entry clearfix">
					<div class="entry-image hidden-sm">
									<img src="'.URL.'/uploads/resimler/'.$IsGoster["RESIMADI"].'" alt="Inventore voluptates velit totam ipsa tenetur">
					</div>
					<div class="entry-c">
							<div class="entry-title">
									<h2><a href="#">'.$IsGoster["ISADI"].'</a></h2>
							</div>
							<ul class="entry-meta clearfix">
									<li><a href="#"><i class="icon-time"></i> '.$IsGoster["BASLAMATARIHI"].' - '.$IsGoster["BITISTARIHI"].'</a></li>
									<li><a href="#"><i class="icon-map-marker2"></i> '.$IsGoster["ISYERI"].'</a></li>
							</ul>
							<div class="entry-content">
									<span class="label label-warning">Açıklama</span>
									<p>'.html_entity_decode($IsGoster["ACIKLAMA"]).'</p>
							</div>
					</div>
			</div>';
			}
		}else{
			echo "Hiç iş eklenmemiş";
		}
		$db->Disconnect();
	}
//========================================================================================================
	function Haberler($limit = 4){
		$db = new Database();
		$HaberBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_HABERLER LIMIT $limit");
		if(count($HaberBul) != NULL){
		foreach ($HaberBul as $HaberGoster) {
			echo'<div class="entry clearfix">
					<div class="entry-image hidden-sm">
									<img src="'.URL.'/uploads/haberler/'.$HaberGoster["RESIM"].'" >
					</div>
					<div class="entry-c">
							<div class="entry-title">
									<h2><a href="#">'.$HaberGoster["BASLIK"].'</a></h2>
							</div>
							<ul class="entry-meta clearfix">
									<li><a href="#"><i class="icon-time"></i>'.$HaberGoster["EKLEMETARIHI"].'</a></li>
							</ul>
							<div class="entry-content">
									<span class="label label-warning">Açıklama</span>
									<p>'.html_entity_decode($HaberGoster["ICERIK"]).'</p>
							</div>
					</div>
			</div>';
			}
		}else{
			echo "Hiç iş eklenmemiş";
		}
		$db->Disconnect();
	}
//========================================================================================================
	function PopupMesaj($limit = 1){
		$db = new Database();
		$PopupMesajBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_POPUPMESAJ WHERE DURUM = 1 LIMIT $limit");
		if ($PopupMesajBul != ''){
			foreach ($PopupMesajBul as $PopupMesajGoster){
                SetCookie('cerez','Fmtmice',1);
				if($PopupMesajGoster !=0 && !@$_COOKIE['Fmtmice']){
                    echo'<script>
                          $( function() {
                            $( ".modal" ).dialog();
                          } );
                          </script>';
                    setcookie("Babo-Sushi", true, time() + (60 * 60 * 24)); // 1 günlük cookie

					echo'


												<!-- Large modal -->

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-body">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">'.$PopupMesajGoster["BASLIK"].'</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>'.html_entity_decode($PopupMesajGoster["MESAJ"]).'</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         ';

				}else{
					return false;
				}
			}
		}else {
			return false;
		}
		$db->Disconnect();
	}
//========================================================================================================

    function SayfaList($Limit = 7){
        $db = new Database();
        $SayfaListBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_SAYFALAR ORDER BY ID ASC LIMIT $Limit");
        if(count($SayfaListBul) != NULL){
            foreach($SayfaListBul AS $key => $SayfaListGoster){
                echo '<li><a href="'.URL.'/Sayfa/'.$SayfaListGoster['LINK'].'.html">'.$SayfaListGoster['SAYFABASLIGI'].'</a></li>';
            }
        }else{
            echo "Hiç sayfa eklenmemiş!";
        }
        $db->Disconnect();
	}
//========================================================================================================
    function DuyuruList($Limit = 7){
        $db = new Database();
        $DuyuruListBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_DUYURULAR WHERE durum = 1 ORDER BY ID ASC LIMIT $Limit");
        if(count($DuyuruListBul) != NULL){
            foreach($DuyuruListBul AS $key => $DuyuruListGoster){
                echo'<a href="'.URL.'/Duyuru/'.$DuyuruListGoster["LINK"].'.html">'.kisalt($DuyuruListGoster["DUYURUBASLIK"]).'</a>';
            }
        }else{
            echo "Hiç duyuru eklenmemiş!";
        }
        $db->Disconnect();
	}
//========================================================================================================
    function ResimList($Limit = 8){
        $db = new Database();
        $ResimListBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_RESIMLER ORDER BY RESIMID ASC LIMIT $Limit");
        if(count($ResimListBul) != NULL){
            foreach($ResimListBul AS $key => $ResimListGoster){
                echo '<a href="uploads/resimler/'.$ResimListGoster['RESIMADI'].'" data-lightbox="gallery-item"><img class="image_fade" src="uploads/resimler/'.$ResimListGoster['RESIMADI'].'" alt="FMTMİCE"></a>';
            }
        }else{
            echo "Hiç resim eklenmemiş!";
        }
        $db->Disconnect();
	}
//========================================================================================================
    function ResimListGoster(){
        $db = new Database();
        $ResimListBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_RESIMLER ORDER BY RESIMID DESC");
        foreach($ResimListBul AS $key => $ResimListGoster){
            echo'<div class="gallery-item type-gallery-item  gallery-item isotope-item food ">
                                    <figure>
                                        <a rel="lightbox[gallery]" class="pretty-photo zoom" href="uploads/resimler/'.$ResimListGoster['RESIMADI'].'" title="Sahlep">
                                        <img class="img-border" src="uploads/resimler/'.$ResimListGoster['RESIMADI'].'" alt="Sahlep">
                                        </a>
                                    </figure>
                                    <h5 class="item-title"><a href="" title="Fmtmice">Fmtmice</a></h5>
                                </div>';
        }

        $db->Disconnect();
	}
//========================================================================================================
    function VideoList($Limit = 1){
        $db = new Database();
        $VideoListBul = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_VIDEOLAR ORDER BY ID DESC LIMIT $Limit");
        $Videomp4 = $VideoListBul["VIDEO"];
        $YoutubeEmbed = $VideoListBul["VIDEOLINK"];
        $EmbedLink = explode ('https://www.youtube.com/watch?v=',$YoutubeEmbed);
        if($Videomp4 > 0){
            echo'<video controls style="width:500px;height:281px;" poster="'.URL.'/uploads/videolar/preview.png">
                                    <source src="'.URL.'/uploads/videolar/'.$Videomp4.'" type="video/mp4" />
                                    <source src="'.URL.'/uploads/videolar/'.$Videomp4.'" type="video/webm" />
                                    </video>';
        }else{
            echo'<iframe width="500" height="281" src="http://www.youtube.com/embed/'.@$EmbedLink[1].'" frameborder="0" allowfullscreen></iframe>';
        }
        $db->Disconnect();
    }
//========================================================================================================
    function VideoListGoster(){
        $db = new Database();
        $VideoListBul = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_VIDEOLAR ORDER BY ID DESC");
        foreach($VideoListBul AS $key => $VideoListGoster){
            $YoutubeEmbed = $VideoListGoster["VIDEOLINK"];
            $EmbedLink = explode ('https://www.youtube.com/watch?v=',$YoutubeEmbed);
            echo'<div class="gallery-item type-gallery-item status-publish hentry gallery-item isotope-item food ">
                                <figure>
                                    <a class="pretty-photo zoom" href="'.$VideoListGoster['VIDEOLINK'].'" rel="lightbox[gallery]" title="">
                                     <img src="http://img.youtube.com/vi/'.$EmbedLink[1].'/0.jpg">
    
                                    </a>
                                </figure>
                            </div>';
        }

        $db->Disconnect();
    }
//========================================================================================================
    function UrunleriGoster($itemName){
        $db = new Database();
        $UrunleriCek = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_SHOPPINGITEMS WHERE CATEGORY = ? ",[$itemName]);

        if ($UrunleriCek>0) {
            foreach ($UrunleriCek as $key => $UrunleriGoster) {
                $productImageID = $UrunleriGoster['id'];
                $itemImage = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_IMAGES WHERE PRODUCTID = ? ",[$productImageID]);
                echo'
                  
                <div class="item">
                
                  <div class="product-preview">
                <form class="item_form">
                    <div class="preview ">';

                if ($itemImage['ID'] !=NULL) {
                    echo'<a href="'.URL.'/bestellung/Produkt/'.$UrunleriGoster["LINK"].'.html"><img class="img-responsive animate scale" src="'.URL.'/uploads/images/thumb/'.$itemImage["THUMBNAIL"].'" alt=""></a>';
                    } else {
                    echo'<a href="'.URL.'/bestellung/Produkt/'.$UrunleriGoster["LINK"].'.html"><img class="img-responsive animate scale" src="'.URL.'/uploads/images/thumb/no-image-thumbnail.png" alt=""></a>';
                }

                if ($UrunleriGoster["ANGEBOT"] > 0) {
                    echo'<ul class="product-controls-list right">
                            <li><span class="label label-sale">SALE</span></li>
                            <li><span class="label">'.$UrunleriGoster["ANGEBOT"].'%</span></li>
                          </ul>';
                }

                echo'</div>
                    Menge:
                        <select name="item_qty">';
                $maxQty=10;
                for($i=1;$i<=$maxQty;$i++){
                    echo "<option value='{$i}'>$i</option>";
                }
                echo'
                        </select>
                    <h3 class="title"><a href="'.URL.'/bestellung/Produkt/'.$UrunleriGoster["LINK"].'.html">'.$UrunleriGoster["item_name"].'<span class="price new">('.$UrunleriGoster["item_id"].')</span></a></h3>
                                    ';

                if ($UrunleriGoster["OLDPRICE"] > 0) {
                    echo'<span class="price old">€'.sprintf("%.2f",($UrunleriGoster["OLDPRICE"])).'</span>';
                }

                echo'<span class="price new">€'.sprintf("%.2f",($UrunleriGoster["item_price"])).'</span>
    
                                    <div class="product-options">
                                            <a href="'.URL.'/Seite/impressum.html"><i class="icon icon-size">'.$UrunleriGoster['item_code'].'</i></a>
                                    </div>
                    <input name="item_id" type="hidden" value="'.$UrunleriGoster["item_id"].'">
                    <button class="btn btn-mega pull-center add_item_to_cart" type="submit">In den Warenkorb</button>
                    </form>';

                if ($UrunleriGoster["id"] == 212) {
                        echo'<div class="panel-group accordion-simple" id="product-accordion" style="margin: 0; padding: 0;">
                            <div class="panel" style="margin-left: 5px;">
                                <div class="panel-heading"> <a data-toggle="collapse" data-parent="#product-accordion" href="#product-description" class="collapsed"> <span class="arrow-down icon-arrow-down-4"></span> <span class="arrow-up icon-arrow-up-4"></span> Topping: </a> </div>
                                <div id="product-description" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">
                                    <small><em>Wählen Sie Ihren Salat zuerst</em></small><hr>
                                    <form class="item_form"><small><input name="item_qty" type="hidden" value="1"><input type="hidden" name="item_id" value="1061"> Hühnchen €3.00 <button class="add_item_to_cart" type="submit">+</button></small></form><hr>
                                    <form class="item_form"><small><input name="item_qty" type="hidden" value="1"><input type="hidden" name="item_id" value="1062"> 5 Grill Garnelen €4.50 <button class="add_item_to_cart" type="submit">+</button></small></form><hr>
                                    <form class="item_form"><small><input name="item_qty" type="hidden" value="1"><input type="hidden" name="item_id" value="1063"> 4 Garnelen Tempura €4.50 <button class="add_item_to_cart" type="submit">+</button></small></form><hr>
                                    <form class="item_form"><small><input name="item_qty" type="hidden" value="1"><input type="hidden" name="item_id" value="1064"> Sashimi vom Thunfisch / lachs €5.50 <button class="add_item_to_cart" type="submit">+</button></small></form>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }

                echo'
                    </div>
                   </div>';


            }
        }else {
            return false;
        }
        unset($UrunleriCek,$UrunleriGoster,$itemImage);
        $db->Disconnect();
    }
//========================================================================================================
function userLoginRegister(){
        $userLoginRegister  = NULL;
        $userLoginRegister .= '
            <!-- Start Login/Register Popup -->
      <div class="login-popup container hero-header">
        <div class="row">
    			<div class="col-sm-12 text-center">
    				<div class="panel panel-form">
    					<div class="panel-heading">
    						<div class="row">
    							<div class="col-xs-6">
    								<a href="#" class="active" id="login-form-link">Login</a>
    							</div>
    							<div class="col-xs-6">
    								<a href="#" id="register-form-link">Register</a>
    							</div>
    						</div>
    						<hr>
    					</div>
    					<div class="panel-body">
    						<div class="row">
    							<div class="col-lg-12">
    								    <form id="login-form" action="index.php?do=LoginRegister" method="post">
    									<div class="form-group">
    										<input type="text" name="username" id="login-username" tabindex="1" class="form-control" placeholder="Username" value="">
    									</div>
    									<div class="form-group">
    										<input type="password" name="password" id="login-password" tabindex="2" class="form-control" placeholder="Password">
    									</div>
    									<div class="form-group text-center">
    										<input type="checkbox" tabindex="3" class="" name="remember" value="1" id="remember">
    										<label for="remember"> Remember Me</label>
    									</div>
    									<div class="form-group">
    										<input type="submit" name="LoginSubmit" id="login-submit" tabindex="4" class="form-control btn btn-submit" value="Log In">
    									</div>
    									<div class="form-group">
    										<div class="row">
    											<div class="col-lg-12">
    												<div class="text-center">
    													<a href="#" tabindex="5" class="login-forgot-password">Forgot Password?</a>
    												</div>
    											</div>
    										</div>
    									</div>
    								</form>
    								<form id="register-form" action="index.php?do=LoginRegister" method="post">
    									<div class="form-group">
    										<input type="text" name="username" id="register-username" tabindex="1" class="form-control" placeholder="Username" value="">
    									</div>
    									<div class="form-group">
    										<input type="email" name="text" id="register-email" tabindex="1" class="form-control" placeholder="Email Address" value="">
    									</div>
    									<div class="form-group">
    										<input type="password" name="password" id="register-password" tabindex="2" class="form-control" placeholder="Password">
    									</div>
    									<div class="form-group">
    										<input type="password" name="confirm-password" id="register-confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
    									</div>
    									<div class="form-group">
    										<input type="submit" name="RegisterSubmit" id="register-submit" tabindex="4" class="form-control btn btn-submit" value="Register Now">
    									</div>
    								</form>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
      </div>
      <!-- End Login/Register Popup -->
        ';
        return $userLoginRegister;

}
//========================================================================================================
function userProfil(){
        $userProfil  = NULL;
        $userProfil .= '
            <!-- Start Login/Register Popup -->
      <div class="login-popup container hero-header">
        <div class="row">
    			<div class="col-sm-12 text-center">
    				<div class="panel panel-form">
    					
    					<div class="panel-body">
    						<div class="row">
    							<div class="col-lg-12">
    								    
    								<form id="register-form" action="index.php?do=LoginRegister" method="post">
    									<div class="form-group">
    										<input type="text" name="username" id="register-username" tabindex="1" class="form-control" placeholder="Username" value="">
    									</div>
    									<div class="form-group">
    										<input type="email" name="text" id="register-email" tabindex="1" class="form-control" placeholder="Email Address" value="">
    									</div>
    									<div class="form-group">
    										<input type="password" name="password" id="register-password" tabindex="2" class="form-control" placeholder="Password">
    									</div>
    									<div class="form-group">
    										<input type="password" name="confirm-password" id="register-confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
    									</div>
    									<div class="form-group">
    										<input type="submit" name="RegisterSubmit" id="register-submit" tabindex="4" class="form-control btn btn-submit" value="Register Now">
    									</div>
    								</form>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
      </div>
      <!-- End Login/Register Popup -->
        ';
        return $userProfil;

}
//========================================================================================================