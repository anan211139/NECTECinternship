@if(session()->has('student_score_allsubject'))
  <div class="content">
      <h1 id="label">ทุกวิชา</h1>
      <div class="layoutContent">
          <div id="pieChart">
              <p>Pie Chart</p>
              <canvas id="barChart_allsubject"></canvas>
          </div>
          <div id="barChart">
              <p>Bar Chart</p>
              <canvas id="pieChart_allsubject"></canvas>
          </div>
      </div>
  </div>
@endif
@if(session()->has('student_score_chapter'))
  <div class="content">
      <h1 id="label">ทุกวิชา</h1>
      <div class="layoutContent">
          <div id="pieChart">
              <p>Pie Chart</p>
              <canvas id="barChart_chapter"></canvas>
          </div>
          <div id="barChart">
              <p>Bar Chart</p>
              <canvas id="pieChart_chapter"></canvas>
          </div>
          <div id="lineChart">
              <p>Bar Chart</p>
              <canvas id="lineChart_chapter"></canvas>
          </div>
      </div>
  </div>
@endif
@if(session()->has('student_score'))
  <div class="content">
      <h1 id="label">ทุกวิชา</h1>
      <div class="layoutContent">
          <div id="pieChart">
              <p>Pie Chart</p>
              <canvas id="barChart_subject"></canvas>
          </div>
          <div id="barChart">
              <p>Bar Chart</p>
              <canvas id="pieChart_subject"></canvas>
          </div>
      </div>
  </div>
@endif
