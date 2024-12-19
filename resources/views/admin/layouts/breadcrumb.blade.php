<style>
    .custom-breadcrumb {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .breadcrumb {
        margin-bottom: 0;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }

    .breadcrumb-item a {
        color: #0d6efd;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #0a58ca;
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #495057;
        font-weight: 500;
    }

    .greeting {
        margin-left: auto;
        color: #495057;
    }
</style>

<div class="mt-4">
    <nav aria-label="breadcrumb">
        <div class="custom-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
            </ol>
            <div class="greeting">Xin chào {!! getLoggedInUser()->name !!}</div>
        </div>
    </nav>
</div>