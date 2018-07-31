@for($i=0;$i<count($subject_list);$i++)
  {{$subject_list["$i"]["name"]}}
  @for($j=0;$j<count($chapther_list);$j++)
    @if($subject_list["$i"]["id"] == $chapther_list["$j"]["subject_id"])
      {{$chapther_list["$j"]["name"]}}
    @endif
  @endfor
@endfor

<ul class="main-navigation" onmouseover="hover();" onmouseout="unhover();">
    <li class="list"><a class="a">ภาษาอังกฤษ <img id="rightarrow" class="dropdownicon" src="picture/right-arrowblack.png"></a>
      <ul class="main-navigation">
        <li class="list"><a class="a" href="#Grammar">Grammar</a></li>
        <li class="list"><a class="a" href="#Listening">Listening</a></li>
      </ul>
    </li>
</ul>
<ul class="main-navigation" onmouseover="hover2();" onmouseout="unhover2();">
    <li class="list"><a class="a">คณิตศาสตร์ <img id="rightarrow2" class="dropdownicon" src="picture/right-arrowblack.png"></a>
        <ul class="main-navigation">
          <li class="list"><a class="a">สมการ</a></li>
          <li class="list"><a class="a">หรม./ครน.</a></li>
        </ul>
    </li>
</ul>








@for($i=0;$i<count($subject_list);$i++)
    <ul class="main-navigation" onmouseover="hover();" onmouseout="unhover();">
        <li class="list"><a class="a">{{$subject_list["$i"]["name"]}}<img id="rightarrow" class="dropdownicon" src="picture/right-arrowblack.png"></a>
          @for($j=0;$j<count($chapther_list);$j++)
            @if($subject_list["$i"]["id"] == $chapther_list["$j"]["subject_id"])
              <ul class="main-navigation">
                <li class="list"><a class="a" href="#Grammar">{{$chapther_list["$j"]["name"]}}</a></li>
              </ul>
            @endif
          @endfor
        </li>
    </ul>
@endfor
