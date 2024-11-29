<style>
.pp-wrapper {
    position: relative;
}

.pp-round {
    width: 46px;
    height: 46px;
    background: linear-gradient(180deg, #56b3ff 0%, #36a3fb 100%);
    border-radius: 100px;
    display: flex;
    justify-content: center;
    cursor: pointer;
    align-items: center;
    transition: .2s ease filter;
}

.pp-round:hover {
    filter: brightness(1.1);
}

.pp-round > span {
    color: white;
    font-weight: bold;
    font-size: 16px;
}

.pp-menu {
    position: absolute;
    top: 52px;
    right: 2px;
    min-width: 150px;
    background-color: var(--background-color);
    border: 1px solid #c4d2e77b;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    padding: 8px;
    transform: scale(0.5);
    opacity: 0;
    transform-origin: top right;
    transition: .2s ease transform, .2s ease opacity;
}

.pp-menu.open {
    transform: scale(1);
    opacity: 1;
}

.pp-menu-item {
    font-size: 14px;
    padding: 8px 10px;
    cursor: pointer;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    color: var(--text-darker-color);
    transition: .2s ease background-color;
}

.pp-menu-item:hover {
    background-color: #f5f5f5;
}
</style>

<div class="pp-wrapper">
    <div class="pp-round" @click="menuOpen = !menuOpen">
        <span><?php echo $initials; ?></span>
    </div>

    <div class="pp-menu">
        <div onclick="setTab('settings')" class="pp-menu-item">Settings</div>
        <div class="pp-menu-item color-red" onclick="logout();">Logout</div>
    </div>
</div>

<script>
    document.querySelector('.pp-round').addEventListener('click', () => {
        document.querySelector('.pp-menu').classList.toggle('open');
    });

    function closePPMenu() {
        document.querySelector('.pp-menu').classList.remove('open');
    }
</script>