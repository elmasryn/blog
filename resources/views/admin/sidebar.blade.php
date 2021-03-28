<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{adminurl('')}}" class="brand-link">
        <img src="{{url('')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ trans('lang.Admin panel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class=" mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{adminurl('settings')}}" class="nav-link {{Request::is('*/settings') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            {{ trans('lang.Settings') }}
                            @if(setting()->website_status == '0')
                            <span class="right badge badge-danger">{{ trans('lang.Closed!') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{adminurl('messages')}}" class="nav-link {{Request::is('*/messages') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            {{ trans('lang.Mailbox') }}
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{Request::is('*/users*') ? 'menu-open' : '' }}">
                    <a href="users" class="nav-link {{Request::is('*/users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{ trans('lang.Latest registered users') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($lastUsers as $user_id => $user_name)
                        <li class="nav-item">
                            <a href="{{url('profile/'.$user_id)}}" target="_blank" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p>{{str_limit($user_name, 25)}}</p>
                            </a>
                        </li>
                        @endforeach
                        <li class="nav-item">
                            <a href="{{adminurl('users')}}"
                                class="nav-link {{Request::is('*/users') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>{{ trans('lang.All users') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{adminurl('users/create')}}"
                                class="nav-link {{Request::is('*/users/create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>{{ trans('lang.Add user') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{Request::is('*/categories*')? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{Request::is('*/categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            {{ trans('lang.Latest categories') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($lastCategories as $category_slug => $category_title)
                        <li class="nav-item">
                            <a href="{{url('posts?category='.$category_slug)}}" target="_blank" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>{{str_limit($category_title, 25)}}</p>
                            </a>
                        </li>
                        @endforeach

                        <li class="nav-item">
                            <a href="{{adminurl('categories')}}" class="nav-link
                                {{Request::is('*/categories') ? 'active' : '' }}">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>{{ trans('lang.All categories') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{adminurl('categories/create')}}"
                                class="nav-link {{Request::is('*/categories/create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>{{ trans('lang.Add category') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{Request::is('*/posts*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{Request::is('*/post*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            {{ trans('lang.Latest added posts') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($lastPosts as $post_slug => $post_title)
                        <li class="nav-item">
                            <a href="{{url('posts?post='.$post_slug)}}" target="_blank" class="nav-link">
                                <i class="fas fa-pen nav-icon"></i>
                                <p>{{str_limit($post_title, 25)}}</p>
                            </a>
                        </li>
                        @endforeach
                        <li class="nav-item">
                            <a href="{{adminurl('posts')}}"
                                class="nav-link {{!request()->has('postTag') && !request()->filled('postTag') ? (Request::is('*/posts') ? 'active' : '' ) : ''}}">
                                <i class="fas fa-edit nav-icon"></i>
                                <p>{{ trans('lang.All posts') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('posts/create')}}" target="_blank" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>{{ trans('lang.Add Post') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{Request::is('*/tags*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{Request::is('*/tag*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            {{ trans('lang.Latest added tags') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($lastTags as $tag_slug => $tag_name)
                        <li class="nav-item">
                            <a href="{{url('posts?tag='.$tag_slug)}}" target="_blank" class="nav-link">
                                <i class="fas fa-tag nav-icon"></i>
                                <p>{{str_limit($tag_name, 25)}}</p>
                            </a>
                        </li>
                        @endforeach
                        <li class="nav-item">
                            <a href="{{adminurl('tags')}}" class="nav-link {{Request::is('*/tags') ? 'active' : '' }}">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>{{ trans('lang.All tags') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{adminurl('tags/create')}}"
                                class="nav-link {{Request::is('*/tags/create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>{{ trans('lang.Add tag') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{Request::is('*/comments*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{Request::is('*/comments*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            {{ trans('lang.Latest comments') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($lastComments as $comment)
                        <li class="nav-item">
                            <a href="{{url('posts/'.$comment->post->slug.'#comment'.$comment->id)}}" target="_blank"
                                class="nav-link">
                                <i class="far fa-comment nav-icon"></i>
                                <p>{{str_limit($comment->body, 25)}}</p>
                            </a>
                        </li>
                        @endforeach
                        <li class="nav-item">
                            <a href="{{adminurl('comments')}}"
                                class="nav-link {{!request()->has('commentPost') && !request()->filled('commentPost') ? (Request::is('*/comments') ? 'active' : '' ) : ''}}">
                                <i class="fas fa-comments nav-icon"></i>
                                <p>{{ trans('lang.All comments') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{Request::is('*/website_contents*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{Request::is('*/website_contents*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-font"></i>
                        <p>
                            {{ trans('lang.Website contents') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{adminurl('website_contents')}}"
                                class="nav-link {{Request::is('*/website_contents') ? 'active' : '' }}">
                                <i class="fas fa-font nav-icon"></i>
                                <p>{{ trans('lang.All website contents') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{adminurl('website_contents/create')}}"
                                class="nav-link {{Request::is('*/website_contents/create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>{{ trans('lang.Add content') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="nav-item has-treeview {{Request::is('*/likes*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link {{Request::is('*/likes*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-thumbs-up"></i>
                    <p>
                        {{ trans('lang.Latest likes') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{url('likes/1')}}" target="_blank" class="nav-link">
                            <i class="far fa-thumbs-up nav-icon"></i>
                            <p>{{ trans('lang.By') }} Guest {{ trans('lang.on') }} Post 1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{adminurl('likes')}}" class="nav-link {{Request::is('*/likes') ? 'active' : '' }}">
                            <i class="fas fa-thumbs-up nav-icon"></i>
                            <p>{{ trans('lang.All likes') }}</p>
                        </a>
                    </li>
                </ul>
                </li> --}}

                <li class="nav-header">{{ trans('lang.Latest Pages') }}</li>
                @foreach ($lastPages as $page_slug => $page_title)
                <li class="nav-item">
                    <a href="{{url('page/'.$page_slug)}}" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            {{str_limit($page_title, 25)}}
                        </p>
                    </a>
                </li>
                @endforeach
                <li class="nav-item">
                    <a href="{{adminurl('pages')}}" class="nav-link {{Request::is('*/pages') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('lang.All Pages') }}
                            <span class="badge badge-info right">{{$Pagescount}}</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{adminurl('pages/create')}}"
                        class="nav-link {{Request::is('*/pages/create') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>
                            {{ trans('lang.Add new Page') }}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>