<?php if (!isset($_SESSION)) { session_start(); } ?>
<?php require VIEWS_PATH.'layouts/head.php'; ?>
<body style="
	background: -webkit-linear-gradient(#121212, #070707 45%);
	background: -o-linear-gradient(#121212, #070707 45%);
	background: -moz-linear-gradient(#121212, #070707 45%);
	background: linear-gradient(#121212, #070707 45%);
">
<div class="ed-container">

		<?php
			if (isset($_SESSION['adv']) && count($_SESSION['adv'])) {
		?>
			<!-- advertising -->
			<div class="ed-item  full  no-padding">
				<div class="advertising">
					<img src="<?php echo getenv('APP_SRC_RESOURCES').$_SESSION['adv'][0]['src'];  ?>" alt="" />
				</div>
			</div>
		<?php } ?>

        <div class="ed-item  full  no-padding">
            <main class="" id="app"></main>
        </div>
    </div>
	<div class="notification blue" id="notification">
		<p class="notification-message"><p>
	</div>

	<?php require VIEWS_PATH.'layouts/dialog.php'; ?>

    <script src="/js/app.js"></script>
</body>
</html>
