@component('admin.layouts.content',['title' => 'کاربران'])

    @slot('breadcrumb')
    <li class="breadcrumb-item "><a href="/admin">پنل مدیریت</a></li>
    <li class="breadcrumb-item active">کاربران</li>
    @endslot
@endcomponent