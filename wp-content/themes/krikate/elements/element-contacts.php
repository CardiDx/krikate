<?
$kontakty_i_rekvizity = get_field('kontakty_i_rekvizity', 'options');
?>
<section class="cooperation section-offset">
    <div class="cooperation__container container">
        <div class="cooperation__wrapper">
            <div class="cooperation__left">
                <?= wp_get_attachment_image($kontakty_i_rekvizity['image'], 'full') ?>
            </div>
            <div class="cooperation__right">
                <div class="contacts-info">
                    <?= $kontakty_i_rekvizity['content'] ?>
                </div>
            </div>
        </div>
    </div>
</section>