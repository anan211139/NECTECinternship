@if(session()->has('student_score_allsubject'))
  <div class="content">
      <h1 id="label">ทุกวิชา</h1>
      <div class="layoutContent">
        <div class="container">
          <canvas id="barChart_allsubject"></canvas>
        </div>
        <div class="container">
          <canvas id="pieChart_allsubject_subj1"></canvas>
        </div>
        <div class="container">
          <canvas id="pieChart_allsubject_subj2"></canvas>
        </div>
      </div>
  </div>
@endif
@if(session()->has('student_score_chapter'))
  <div class="content">
      <h1 id="label">ทุกวิชา</h1>
      <div class="layoutContent">
        <div class="container">
          <canvas id="barChart_chapter"></canvas>
        </div>
        <div class="container">
          <canvas id="pieChart_chapter_easy"></canvas>
        </div>
        <div class="container">
          <canvas id="pieChart_chapter_medium"></canvas>
        </div>
        <div class="container">
          <canvas id="pieChart_chapter_hard"></canvas>
        </div>
        <div class="container">
          <canvas id="lineChart_chapter"></canvas>
        </div>
      </div>
  </div>
@endif
@if(session()->has('student_score'))
  <div class="content">
      <h1 id="label">ทุกวิชา</h1>
      <div class="layoutContent">
        <div class="container">
          <canvas id="barChart_subject"></canvas>
        </div>
        <div class="container">
          <canvas id="pieChart_subject_ch1"></canvas>
        </div>
        <div class="container">
          <canvas id="pieChart_subject_ch2"></canvas>
        </div>
      </div>
  </div>
@endif
