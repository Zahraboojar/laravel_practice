@component('admin.layouts.content',['title' => 'کاربران'])

    @slot('breadcrumb')
    <li class="breadcrumb-item "><a href="/admin">پنل مدیریت</a></li>
    <li class="breadcrumb-item active">کاربران</li>
    @endslot

    <h2>کاربران</h2>
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">کاربران</h3>

                <div class="card-tools d-flex">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    
                    <input type="text" name="table_search" class="form-control float-right" placeholder="جستجو">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="btn-group-sm mr-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success">افزودن</a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                  <tr>
                    <th>ایدی کاربر</th>
                    <th>نام کاربر</th>
                    <th>ایمیل کاربر</th>
                    <th>وضعیت ایمیل</th>
                    <th>اقدامات</th>
                  </tr>
                  
                    @foreach ($users as $user_item)
                    <tr>
                      <td>{{ $user_item->id }}</td>
                      <td>{{ $user_item->name }}</td>
                      <td>{{ $user_item->email }}</td>
                      <td>
                        @if ($user_item->email_verified_at)
                          <span class="badge badge-success">تایید شده</span>
                        @else
                        <span class="badge badge-danger">تایید نشده</span>
                        @endif
                      </td>
                      <td class="d-flex">
                        <a href="{{ route('admin.users.edit', ['user' => $user_item->id]) }}" class="btn btn-sm btn-warning">ویرایش</a>
                        <form method="post" action="{{ route('admin.users.destroy', ['user' => $user_item->id]) }}">
                        @csrf
                        @method('DELETE')  
                        <button type="submit" class="btn btn-sm btn-danger mr-1">حذف</button>
                        </form>
                        
                      </td>
                    </tr>
                    @endforeach
                    
                </tbody></table>
              </div>
            </div>
          </div>
        </div>
@endcomponent