
<div class="mobile-menu-footer">
    <div class="menu-item-footer">
        <a href="<?= $base; ?>"><img src="<?= $base; ?>/assets/images/home-run-alt.png" class="br50" alt="home"></a>
        <a href="<?= $base; ?>/amigos"><img src="<?= $base; ?>/assets/images/friends-alt.png" alt="friends"></a>
        <a  onclick="uploadCall()" ><img src="<?= $base; ?>/assets/images/photo.png" alt="upload"></a>
        <a href="<?= $base; ?>/conversas" class="chat-message-footer" >
            <?php if(count($loggedUser->unreadChats) > 0): ?>
            <div class="noti-qt count-chat"><?= count($loggedUser->unreadChats); ?></div>
            <?php endif; ?>
            <img src="<?= $base; ?>/assets/images/chat.png" alt="message">
        </a>
        <a href="<?= $base; ?>/perfil">
            <img src="<?= $base; ?>/media/avatars/<?= $loggedUser->avatar; ?>" alt="user"  class="br50">
        </a>
    </div>
</div>
<input type="file" name="photo" class="feed-new-file" accept="image/jpeg,image/jpg,image/png">

<div class="modal-photo">
        <div class="modal-close"><img src="<?= $base; ?>/assets/images/close.png" alt="close" /></div>
        <div class="modal-inner">
            <img src="<?= $base; ?>/media/uploads/1.jpg" alt="Imagem" />
        </div>
        <div class="modal-choice">
            <div class="modal-choice-prev"><img src="<?= $base; ?>/assets/images/prev.png" alt="prev"></div>
            <div class="modal-choice-next"><img src="<?= $base; ?>/assets/images/next.png" alt="next"></div>
        </div>
</div>

<script>
    const BASE = "<?= $base; ?>";
    const LOGGEDUSERID = "<?= $loggedUser->id ?>";
</script>
<script type="text/javascript" src="<?= $base; ?>/assets/js/script.js"></script>
<script type="text/javascript" src="<?= $base; ?>/assets/js/modal.js"></script>
<script type="text/javascript" src="<?= $base; ?>/assets/js/requesting.js"></script>
</body>
</html>