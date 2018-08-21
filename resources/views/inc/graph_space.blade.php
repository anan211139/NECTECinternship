@if(session()->has('student_score_allsubject'))
  <div class="content">
      <h1 id="label">ทุกวิชา</h1>
      <div class="barChart">
        <canvas id="barChart_allsubject"></canvas>
      </div>
      <h3 class="labelPie">จำนวนแบบฝึกหัดที่นักเรียนทำได้</h3>
      <div class="layoutContent">
        <!-- <div class="container">
          <canvas id="barChart_allsubject"></canvas>
        </div> -->
        <div>
          <canvas id="pieChart_allsubject_subj1"></canvas>
        </div>
        <div>
          <canvas id="pieChart_allsubject_subj2"></canvas>
        </div>
      </div>
  </div>
  @include('inc.script_overall')
@endif
@if(session()->has('student_score_chapter'))
  <div class="content">
      <h1 id="label">{{$chapterCh['0']['name']}}</h1>
      <div class="barChart">
        <canvas id="barChart_chapter"></canvas>
      </div>
      <h3 class="labelPie">จำนวนแบบฝึกหัดที่นักเรียนทำได้</h3>
      <div class="layoutContent">
          <div>
            <canvas id="pieChart_chapter_easy"></canvas>
          </div>
          <div>
            <canvas id="pieChart_chapter_medium"></canvas>
          </div>
      </div>
      <div style="display:flex; flex-flow: row; justify-content: center; padding: 0px 50px;">
        <div class="thChart" >
          <canvas id="pieChart_chapter_hard"></canvas>
        </div>
      </div>
      <div class="barChart">
        <canvas id="lineChart_chapter"></canvas>
      </div>
  </div>
  <div class="content">
      <h1 id="label">subject</h1>
      <div class="barChart">
        <canvas id="barChart_subject"></canvas>
      </div>
      <h3 class="labelPie">จำนวนแบบฝึกหัดที่นักเรียนทำได้</h3>
      <div class="layoutContent">
        <div>
          <canvas id="pieChart_subject_ch1"></canvas>
        </div>
        <div>
          <canvas id="pieChart_subject_ch2"></canvas>
        </div>
      </div>
  </div>
  @include('inc.script_subject')
  @include('inc.script_chapter')
@endif
