@component('admin.layouts.content',['title' => 'ایجاد کاربر'])

    @slot('breadcrumb')
    <li class="breadcrumb-item "><a href="/admin">پنل مدیریت</a></li>
    <li class="breadcrumb-item "><a href="{{ route('admin.users.index') }}">کاربران</a></li>
    <li class="breadcrumb-item active">ایجاد کاربر</li>
    @endslot
    <div class="row">
        <div class="col-lg-12">
        <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">فرم ایجاد کاربر</h3>
              </div>
              @include('admin.layouts.error')
              <form class="form-horizontal" method="post" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">نام</label>

                    <div class="col-sm-10">
                      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="نام را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">ایمیل</label>

                    <div class="col-sm-10">
                      <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="ایمیل را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">پسورد</label>

                    <div class="col-sm-10">
                      <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="پسورد را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">تکرار پسورد</label>

                    <div class="col-sm-10">
                      <input type="password" name="password_confirmation" class="form-control" id="inputPassword3" placeholder="تکرار پسورد را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" name="verify" class="form-check-input" id="exampleCheck2">
                        <label class="form-check-label"  for="exampleCheck2">اکانت فعال باشد</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">ورود</button>
                  <a href="{{ route('admin.users.index') }}" type="submit" class="btn btn-default float-left">لغو</a>
                </div>
              </form>
            </div>
        </div>
    </div>
@endcomponent