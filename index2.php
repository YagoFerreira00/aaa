<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');


$logged_in = isset($_SESSION['usuario_id']);

$adm = $_SESSION['usuario_adm'];

include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Livro.php';

$livro = new Livro($db);
$usuario = new Usuario($db);

function saudacao()
{
    $hora = date("H");
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia!";
    } else if ($hora >= 12 && $hora < 18) {
        return "Boa tarde!";
    } else {
        return "Boa noite!";
    }
}

try {
    $db = new PDO("mysql:host=localhost;dbname=livraria;charset=utf8", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit;
}

//Processar exlusão da notícia
if(isset($_GET['idlivro'])){
        $idlivro = $_GET['idlivro'];
        $livro->deletarLivro($idlivro);
        header('Location: index.php');
        exit();
    }
// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados das noticias com filtros
 $dados = $livro->ler($search, $order_by);

//Obtem dados do usuário logado
$dados_Usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_Usuario['nome'];

?>

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
    <?php include_once ('header.php'); ?>
    <!-- end header section -->



  


  <!-- about section

  <section class="about_section layout_padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="img_container">
            <div class="img-box b1">
              <img src="images/a-11.jpg" alt="">
            </div>
            <div class="img-box b2">
              <img src="images/logob1.png" alt="">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <h2>
              O que é a Estante Virtual?
            </h2>
            <p>
              There are many variations of passages of Lorem Ipsum
              There are many variations of
              passages of Lorem Ipsum
            </p>
            <a href="">
              Saiba Mais
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  end about section -->


  <!-- product section -->

  <section class="product_section ">
    <div class="container">
      <div class="product_heading">
        <h2>
          Melhores Livros
        </h2>
      </div>
      <div class="product_container">
        <div class="box">
          <div class="box-content">
          <ul class="livroLista">
                <?php while ($livro = $dados->fetch(PDO::FETCH_ASSOC)): ?>
                    <li>
                    <img src="<?php echo htmlspecialchars($livro['caminho']); ?>" alt="<?php echo htmlspecialchars($imagem['nome']); ?>" width="200"><br>
                        <h3><?php echo htmlspecialchars($livro['titulo']) ?></h3>
                        <p>Editora: <?php echo htmlspecialchars($livro['autor']) ?></p>
                        <span> <?php echo htmlspecialchars($livro['ano_publicacao']) ?></span>
                        <a href="verLivro.php?id=<?php echo $livro['idlivro']; ?>"><button class="botao">Ver</button></a>
                        <?php if ($logged_in && $adm == 1): ?>
                            <a href="deletarLivro.php?id=<?php echo $livro['idlivro']; ?>"><button class="botao">Excluir Livro</button></a>
                        <?php endif; ?>
                    </li>
                    <br>
                <?php endwhile; ?>
            </ul>
        </div>
      </div>
    </div>
    
  </section>

  <!-- end product section -->


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
            </div>
          </div>
          <div class="btn-box">
            <a href="livro.php">
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
            </div>
          </div>
          <div class="btn-box">
            <a href="livro.php">
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
            </div>
          </div>
          <div class="btn-box">
            <a href="livro.php">
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
            </div>
          </div>
          <div class="btn-box">
            <a href="livro.php">
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
            </div>
          </div>
          <div class="btn-box">
            <a href="livro.php">
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
            </div>
          </div>
          <div class="btn-box">
            <a href="livro.php">
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


  <!-- client section
  <section class="client_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Testimonial
        </h2>
      </div>
    </div>
    <div id="customCarousel2" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="container">
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/client.jpg" alt="">
                  </div>
                  <div class="detail-box">
                    <div class="client_info">
                      <div class="client_name">
                        <h5>
                          Morojink
                        </h5>
                        <h6>
                          Customer
                        </h6>
                      </div>
                      <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                      labore
                      et
                      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                      aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum
                      dolore eu fugia
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="container">
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/client.jpg" alt="">
                  </div>
                  <div class="detail-box">
                    <div class="client_info">
                      <div class="client_name">
                        <h5>
                          Morojink
                        </h5>
                        <h6>
                          Customer
                        </h6>
                      </div>
                      <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                      labore
                      et
                      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                      aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum
                      dolore eu fugia
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="container">
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/client.jpg" alt="">
                  </div>
                  <div class="detail-box">
                    <div class="client_info">
                      <div class="client_name">
                        <h5>
                          Morojink
                        </h5>
                        <h6>
                          Customer
                        </h6>
                      </div>
                      <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                      labore
                      et
                      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                      aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum
                      dolore eu fugia
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ol class="carousel-indicators">
        <li data-target="#customCarousel2" data-slide-to="0" class="active"></li>
        <li data-target="#customCarousel2" data-slide-to="1"></li>
        <li data-target="#customCarousel2" data-slide-to="2"></li>
      </ol>
    </div>
  </section>
  end client section -->



  <!-- footer section -->
  <?php include_once ('footer.php'); ?>

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