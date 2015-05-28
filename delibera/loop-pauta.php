<?php if (have_posts()) :
while (have_posts()) :
the_post();
$temas = wp_get_post_terms($post->ID, 'tema');
$user_id = get_current_user_id();
$situacao = delibera_get_situacao($post->ID);
$seguir = false;
if (!delibera_ja_seguiu($post->ID, $user_id) && $situacao->slug != 'relatoria') {
$seguir = true;
}
?>
<div class="topic">
  <div class="row">
    <div class="col-sm-9">
      <div class="row mt-md divider-bottom">
        <div class="col-sm-6">
          <div class="meta clearfix">
            <p class="status fontsize-sm text-muted pull-left">
              <i class="fa fa-users"></i>
            <?php echo delibera_get_situacao($post->ID)->name; ?></p>
            <p class="deadline fontsize-sm text-muted pull-left ml-lg">
              <i class="fa fa-calendar"></i>
              <?php if (delibera_get_prazo($post->ID) == -1) {
              echo 'Prazo encerrado';
              } else {
              printf(_n('Encerra em um dia', 'Encerra em %1$s dias', delibera_get_prazo($post->ID), 'delibera'), number_format_i18n(delibera_get_prazo($post->ID)));
              } ?>
            </p>
          </div>
        </div>
        <div class="col-sm-6">
          <select class="form-control">
            <option selected>Navegue por eixos</option>
            <option>Lorem ipsum dolor sit amet, consectetur adipiscing elit</option>
            <option>Vivamus tincidunt turpis sed ex aliquam varius</option>
            <option>Cras venenatis magna vitae urna faucibus</option>
            <option>Mauris venenatis massa in dolor tempor posuere</option>
          </select>
        </div>
      </div>
      <h4 class="red"><strong>
      <?php the_title(); ?>
      </strong></h4>
      <div class="mt-sm clearfix">
        <p class="meta fontsize-sm pull-left">Discussão criada por <strong class="author text-danger">
          <?php
          $autor_exibicao = get_post_meta(get_the_ID(), '_autor_exibicao', true);
          if (isset($autor_exibicao) && $autor_exibicao != "") {
          echo $autor_exibicao;
          } else {
          the_author();
          }
          ?>
          </strong> em <strong class="date text-danger">
          <?php the_date('d/m/y'); ?>
          </strong>
        </p>
        <?php if (!empty($temas)) : ?>
        <p class="meta fontsize-sm text-muted ml-lg pull-left">Tema:
          <a href="#">
            <?php $size = count($temas) - 1; ?>
            <?php foreach ($temas as $key => $tema) : ?>
            <a href="<?php echo get_post_type_archive_link('pauta') . "?tema_filtro[{$tema->slug}]=on"; ?>">
            <?php echo $tema->name; ?></a>
            <?php echo ($key != $size) ? ',' : ''; ?>
            <?php endforeach; ?>
          </p>
          <?php endif; ?>
        </div>
        <div class="content">
          <?php the_content(); ?>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="panel panel-default text-center">
          <div class="panel-body">
            <p class="h1 red font-roboto"><i class="fa fa-comments-o"></i> 00000</p>
            <p><strong>Comentários</strong></p>
          </div>
          <div class="panel-footer">
            <p class="h4"><a href="#"><strong>Participe!</strong></a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="divider-top mb-lg">
      <div class="row">
        <div class="col-md-5 mt-sm">
          Vote:
          <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i> Concordo</button>
            <button type="button" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i> Discordo</button>
          </div>
          10 votos no total
        </div>
        <div class="col-md-7 mt-sm text-right">
          <div class="btn-group" role="group" aria-label="...">
            <?php $social_share_url = pensandoodireito_bitly_url(get_the_permalink()); ?>
            <a href="javascript:var socialw = window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $social_share_url; ?>', 'socialw', 'width=470, height=250, location=no');" class="btn btn-default fontsize-sm text-muted"><i class="fa fa-facebook-square"></i> Facebook</a>
            <a href="javascript:var socialw = window.open('http://www.twitter.com/share?url=<?php echo $social_share_url; ?>', 'socialw', 'width=470, height=280, location=no');" class="btn btn-default fontsize-sm text-muted"><i class="fa fa-twitter"></i> Twitter</a>
            <a href="javascript:var socialw = window.open('https://plus.google.com/share?url=<?php echo $social_share_url; ?>', 'socialw', 'width=470, height=250, location=no');" class="btn btn-default fontsize-sm text-muted"><i class="fa fa-google-plus"></i> Google+</a>
            <a href="#" class="btn btn-default fontsize-sm text-muted" id="delibera_seguir">
              <span id="delibera-seguir-text" <?php if (!$seguir) echo ' style="display: none;" ';?>><i class="fa fa-star-o"></i> Seguir</span>
              <span id="delibera-seguindo-text"  <?php if ($seguir) echo ' style="display: none;" ';?>><i class="fa fa-star red"></i> Seguindo</span>
            </a>
            <a href="?delibera_print=1" class="btn btn-default fontsize-sm text-muted"><i class="fa fa-print"></i> Imprimir</a>
          </div>
        </div>
      </div>
    </div>
    <?php comments_template( '', true ); ?>
  </div>
  <?php endwhile; ?>
  <?php endif; ?>