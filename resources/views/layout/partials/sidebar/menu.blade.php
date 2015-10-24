<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    @foreach ($menus as $key => $menu)
        @can($menu['permission'])
        @if($key=='dashboard' && $active === null)
        <li class="active">
        @else
        <li class="{{ ($key==$active) ? 'active' : '' }}">
        @endif
            <a href="{{ route('admin.'.$key.'.index') }}">
                <i class="fa {{ $menu['icon'] }}"></i><span class="fa-fw">{{ trans($menu['name']) }}</span>
            </a>
        </li>
        @endcan
    @endforeach
    <li class="header">TEST</li>    
<li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Tables</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                <li><a href="tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
              </ul>
            </li>

<li>
              <a href="mailbox/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="label pull-right bg-yellow">12</small>
              </a>
            </li>


    <li class="header">SYSTEM</li>
    <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>    
</ul>