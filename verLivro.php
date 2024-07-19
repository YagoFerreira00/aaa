<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Livro.php';
include_once './classes/Comentario.php';

$livro = new Livro($db);

$comentario = new Comentario($db);

$dadosLivro = $livro->lerPoridlivro($_GET['id']);

$jaComentou = false;
$idComentarioUsuario = null;

$dadosComentario = $comentario->lerPorIdliv($_GET['id']);

foreach($dadosComentario as $item){
    if($item['idusu'] == $_SESSION['usuario_id']){
        $jaComentou = true;
        $idComentarioUsuario = $item['idcoment'];
}
}
$dadosComentario = $comentario->lerPorIdliv($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoRegis']) && !$jaComentou) {
    $comentarios = new Comentario($db);
    $comentario = $_POST['comentario'];
    $data = date('Y-m-d');
    $idUsu = $_SESSION['usuario_id'];
    $idLiv = $_GET['id'];
    $titulo = $_POST['titulo'];
    $comentarios->criar($idUsu, $idLiv, $data, $titulo, $comentario);
    header("Refresh:0");
    exit;
}else{
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoRegis']) && $jaComentou) {
        $comentarios = new Comentario($db);
        $comentario = $_POST['comentario'];
        $data = date('Y-m-d');
        $idUsu = $_SESSION['usuario_id'];
        $idLiv = $_GET['id'];
        $titulo = $_POST['titulo'];
        $comentarios->atualizar($idUsu, $idLiv, $data, $titulo, $comentario, $idComentarioUsuario);
        header("Refresh:0");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botaoDelet'])) {
    $comentario->deletar($_POST['botaoDelet']);
    header("Refresh:0");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="images/fevicon/fevicon.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Estante Virtual</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body>

  <div class="hero_area">
    <!-- header section strats -->
    <?php include_once('header.php'); ?>
    <!-- end header section -->
    <!-- slider section
    <section class="slider_section ">
      <div class="slider_bg_box">
        <img src="images/slider-bg.jpg" alt="">
      </div>
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Livro foda
                    </h1>
                    <p>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Comentar
                      </a>
                      <a href="" class="btn2">
                        Avaliar
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Livro Zika
                    </h1>
                    <p>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Comentar
                      </a>
                      <a href="" class="btn2">
                        Avaliar
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Livro Top
                    </h1>
                    <p>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Comentar
                      </a>
                      <a href="" class="btn2">
                        Avaliar
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Livro Show de Bola
                    </h1>
                    <p>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Comentar
                      </a>
                      <a href="" class="btn2">
                        Avaliar
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Livro do balacobaco
                    </h1>
                    <p>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn1">
                        Comentar
                      </a>
                      <a href="" class="btn2">
                        Avaliar
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <ol class="carousel-indicators">
          <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
          <li data-target="#customCarousel1" data-slide-to="1"></li>
          <li data-target="#customCarousel1" data-slide-to="2"></li>
          <li data-target="#customCarousel1" data-slide-to="3"></li>
          <li data-target="#customCarousel1" data-slide-to="4"></li>
        </ol>
      </div>

    </section>
     end slider section -->






    <!-- about section -->

    <section class="about_section layout_padding">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="img_container">
              <div>
              <img src="<?php echo htmlspecialchars($dadosLivro['caminho']); ?>" alt="<?php echo htmlspecialchars($imagem['nome']); ?>" width="100">
              </div>
              <!--<div class="img-box b2">
              <img src="images/a-22.png" alt="">
            </div>-->
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-box">
              <h2>
              <?php echo htmlspecialchars($dadosLivro['titulo']) ?>
              </h2>
              <h6>Editora:
              <?php echo htmlspecialchars($dadosLivro['autor']) ?>
              </h6>
              <p> Ano Publicação:
              <?php echo htmlspecialchars($dadosLivro['ano_publicacao']) ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end about section -->


    <!-- product section

  <section class="product_section ">
    <div class="container">
      <div class="product_heading">
        <h2>
          Melhores Livros de ROMANCE
        </h2>
      </div>
      <div class="product_container">
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w11.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Romance 1</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w22.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Romance 2</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w33.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Romance 3</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  < end product section -->


    <!-- product section 

  <section class="product_section ">
    <div class="container">
      <div class="product_heading">
        <h2>
          Melhores Livros de MISTÉRIO
        </h2>
      </div>
      <div class="product_container">
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w44.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Mistério 1</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w55.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Mistério 2</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w66.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Mistério 3</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>


   end product section -->


    <!-- product section 

  <section class="product_section ">
    <div class="container">
      <div class="product_heading">
        <h2>
          Melhores Livros de LITERATURA INFANTIL
        </h2>
      </div>
      <div class="product_container">
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w77.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Literatura Infantil 1</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w88.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Literatura Infantil 2</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
        <div class="box">
          <div class="box-content">
            <div class="img-box">
              <img src="images/w99.png" alt="">
            </div>
            <div class="detail-box">
              <div class="text">
                <h6>
                  Editora
                </h6>
                <h5>
                  <span>Literatura Infantil 3</span>
                </h5>
              </div>
              <div class="like">
                <h6>
                Avaliação
                </h6>
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <a href="">
              Ver livro
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>


   end product section -->

    <!-- contact section
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Contact Us
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="">
              <div>
                <input type="text" placeholder="Your Name" />
              </div>
              <div>
                <input type="text" placeholder="Phone Number" />
              </div>
              <div>
                <input type="email" placeholder="Email" />
              </div>
              <div>
                <input type="text" class="message-box" placeholder="Message" />
              </div>
              <div class="btn_box">
                <button>
                  SEND
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6 ">
          <div class="map_container">
            <div class="map">
              <div id="googleMap"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  end contact section -->


    <!-- client section -->
    <section class="client_section layout_padding-bottom">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>
            Deixe seu comentario sobre este livro!
          </h2>
          <br>
          <div class="form_container">
          <form method="POST">
            <label for="titulo">Titulo do comentario: </label>
            <input class="campText" type="text" name="titulo" required> <br><br>
            <label for="comentario">Comentario: </label>
            <input class="campText" type="text" name="comentario" required><br><br>
            <div class="botoes">
                <input class="botao" type="submit" name="botaoRegis" value="Adicionar">
            </div>
        </form>
            <br><br>
              <h2>
            Comentarios dos leitores:
          </h2>
        </div>
              <div class="container">
                <div class="row">
                  <div class="col-md-10 mx-auto">
                    <div class="box">
                    <?php while ($comentario = $dadosComentario->fetch(PDO::FETCH_ASSOC)): ?>
        <li>
            <h1> user <?php echo htmlspecialchars($comentario['idusu']) ?></h1>
            <h2>titulo:<?php echo htmlspecialchars($comentario['titulo']) ?></h2>
            <p> <?php echo htmlspecialchars($comentario['comentario']) ?></p>
            <?php if ($comentario['idusu'] == $_SESSION['usuario_id']): ?>
                <form method="post">
                    <button type="submit" name="botaoDelet" value="<?php echo $comentario['idcoment']; ?>">Apagar comentario</button>
                </form>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>
                    </div>
                  </div>
                </div>
              </div>
    </section>
    <!-- end client section -->



    <!-- footer section -->
    <?php include_once('footer.php'); ?>

    <!-- jQery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- custom js -->
    <script type="text/javascript" src="js/custom.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->

</body>

</html>