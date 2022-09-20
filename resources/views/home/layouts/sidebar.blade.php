<nav id="sidebar" class="container">
    <div class="pl-4 pt-5 ml-2">
        <ul class="list-unstyled components mb-5">
            <li class="mb-2 {{ request()->is('user*') ? 'active' : '' }}">
                <a href="/">Home</a>
            </li>
            <li class="mb-2 {{ request()->is('question*') ? 'active' : '' }}">
                <a href="{{ route('question.index') }}">Questions</a>
            </li>
            <li class="mb-2 {{ request()->is('tag*') ? 'active' : '' }}">
                <a href="{{ route('tag.index') }}" class="pl-4">Tags</a>
            </li>
            <li class="mb-2 {{ request()->is('leaderboard*') ? 'active' : '' }}">
                <a href="{{ route('leaderboard.index') }}" class="pl-4">Leaderboard</a>
            </li>
        </ul>
    </div>
</nav>