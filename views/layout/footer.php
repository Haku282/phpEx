<?php
// views/layout/footer.php
?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var userMenu = document.getElementById('user-menu-dropdown');
        if (userMenu) {
            userMenu.addEventListener('click', function(event) {
                this.classList.toggle('show');
                event.stopPropagation();
            });
            // Đóng dropdown nếu click ra ngoài
            window.addEventListener('click', function(event) {
                if (userMenu.classList.contains('show')) {
                    userMenu.classList.remove('show');
                }
            });
        }
        // JS cho Flash Message (từ bài trước)
        const flashMessages = document.querySelectorAll('.flash-message');
        if (flashMessages.length > 0) {
            setTimeout(() => {
                flashMessages.forEach(function(message) {
                    message.style.opacity = '0';
                    setTimeout(() => message.style.display = 'none', 500);
                });
            }, 5000);
        }
    });
</script>
</body>

</html>