<nav>
    <div class="flex">
        <div class="basis-2/12">
            <h3 class="text-white">{{ env('APP_NAME') }}</h3>
        </div>

        <div class="basis-10/12">
            <ul>
                <a href="/profile">
                    <li>Profile</li>
                </a>

                <li class="btn">
                    <form action="logout" method="post">
                        @csrf

                        <button type="submit" class="bg-danger">Logout</button>
                    </form>
                </li>

            </ul>
        </div>
    </div>

</nav>
