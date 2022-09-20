<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-text mx-3"><img src="{{ asset('assets/img/logo-white.png') }}" alt="..." width="30px" class="mb-1"> Frage</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard.index') }}">
        <i class="fa-solid fa-table-columns"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/data-admin*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dataAdmin.index') }}">
        <i class="fa-solid fa-user-shield"></i>
        <span>Data Admin</span>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/data-user*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dataUser.index') }}">
        <i class="fa-solid fa-user"></i>
        <span>Data User</span>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/data-question*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dataQuestion.index') }}">
        <i class="fa-solid fa-folder"></i>
        <span>Data Question</span>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/data-answer*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dataAnswer.index') }}">
        <i class="fa-solid fa-folder"></i>
        <span>Data Answer</span>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/data-tags*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dataTags.index') }}">
        <i class="fa-solid fa-hashtag"></i>
        <span>Data Tags</span>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/question-report*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dataQuestionReport.index') }}">
        <i class="fa-solid fa-flag"></i>
        <span>Data Question Report</span>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/answer-report*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dataAnswerReport.index') }}">
        <i class="fa-solid fa-flag"></i>
        <span>Data Answer Report</span>
    </a>
</li>
