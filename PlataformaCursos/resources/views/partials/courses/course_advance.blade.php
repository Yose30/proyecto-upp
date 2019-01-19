@cannot('inscribe', $course)
    <div class="row">
        <div class="col-md-11">
            <div class="progress">
                <div 
                    class="progress-bar" 
                    role="progressbar" 
                    style="width: {{ $course_advance->avance }}%;"  
                    aria-valuemin="0" 
                    aria-valuemax="100"
                > 
                {{ $course_advance->avance }}%
                </div>
            </div>
        </div>
        <i class="fa fa-trophy" style="color: yellow; font-size: 30px;"></i>
    </div>
@endcannot