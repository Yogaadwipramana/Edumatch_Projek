<div class="navbar">
    <div class="search">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search (Ctrl+/)" style="border: none; outline: none; flex: 1;">
    </div>

    <div class="icons" style="position: relative;">
        <i class="fas fa-globe"></i>
        <i class="fas fa-sun"></i>
        <i class="fas fa-th-large"></i>
        <i class="fas fa-bell"></i>

        <div class="profile-container" style="position: relative; cursor: pointer;">
            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Profile" class="profile-img" onclick="toggleProfile()" />
            <div id="profile-dropdown" style="display: none; position: absolute; right: 0; top: 45px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px; width: 200px; z-index: 100;">
                <div style="padding: 15px; border-bottom: 1px solid #eee; display: flex; gap: 10px; align-items: center;">
                    <img src="https://randomuser.me/api/portraits/men/75.jpg" class="profile-img" style="width: 40px; height: 40px;">
                    <div>
                        <strong>John Doe</strong>
                        <p style="margin: 0; font-size: 12px; color: gray;">Admin</p>
                    </div>
                </div>
                <div style="padding: 10px 15px; cursor: pointer;">
                    <i class="fas fa-user"></i> My Profile
                </div>
                <div style="padding: 10px 15px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span><i class="fas fa-credit-card"></i> Billing Plan</span>
                    <span style="background: red; color: white; border-radius: 50%; padding: 2px 8px; font-size: 12px;">4</span>
                </div>
                <div style="padding: 10px 15px; cursor: pointer;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleProfile() {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function (e) {
        const profile = document.querySelector('.profile-container');
        const dropdown = document.getElementById('profile-dropdown');
        if (!profile.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>
