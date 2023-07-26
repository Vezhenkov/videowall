/*jshint strict:false*/

class Tools {
    static *getLoopGenerator(a) {
        let i = 0;
        while(true) {
            yield a[i];
            i += 1;
            if (i >= a.length) i = 0;
        }
    }
}

class DailyHandler {
    constructor() {
        this.minutes = null;
        this.hours = null;
        this.date = null;
        this.update();
        setInterval(this.update.bind(this), 1000);
    }

    updateTime(date) {
        let minutes = date.getMinutes();
        let hours = date.getHours();
        this.minutes = minutes < 10 ? `0${minutes}` : `${minutes}`;
        this.hours = hours < 10 ? `0${hours}` : `${hours}`;

        let dateTimeElement = document.querySelector('.date__time');
        dateTimeElement.textContent = `${this.hours}:${this.minutes}`;
    }

    updateDate(date) {
        let allDays = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        let allMonths = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября',
            'октября', 'ноября', 'декабря'];
        let weekDay = allDays[date.getDay()];
        let monthDay = date.getDate();
        let month = allMonths[date.getMonth()];
        this.date = monthDay;

        let dateTodayElement = document.querySelector('.date__today');
        dateTodayElement.textContent = `${weekDay}, ${monthDay} ${month}`;
    }

    update() {
        let date = new Date();
        if(date.getMinutes() !== Number(this.minutes)) {
            this.updateTime(date);
            if(date.getDate() !== this.date) this.updateDate(date);
        }
    }
}

class SlidesHandler {
    getTitleColor(title) {
        switch(title) {
            case '#Спорт': return '#0b8236'
            case '#Наука': return '#d8bb59'
            case '#Инновации': return '#3caae1'
            case '#Образование': return '#e71e4f'
            case '#Международная деятельность': return '#f6a317'
            case '#Рейтинги': return '#cd9676'
            case '#Партнерство': return '#e94446'
            case '#Культура': return '#dc82a3'
            case '#Студенческая жизнь': return '#88b474'
            case '#Предпринимательство и стартапы': return '#3966af'
            case '#Противодействие COVID-19': return '#71001b'
            case '#Патриотическое воспитание': return '#ff0000'
        }
    }

    constructor(VideoWall) {
        this.VideoWall = VideoWall
        this.run().catch()
    }

    updateSlide(slidesGenerator) {
        let slideInfo = slidesGenerator.next().value
        let src = location.origin + '/' + slideInfo.src
        let title = slideInfo.title
        let content = slideInfo.content
        let color = this.getTitleColor(title)
        let slideImageElement = document.querySelector('.slide__image');
        let slideTitleElement = document.querySelector('.slide__title');
        let slideContentElement = document.querySelector('.slide__content');

        slideImageElement.src = src;
        if(!title || !content) {
            slideTitleElement.style.display = 'none';
            slideContentElement.style.display = 'none';
        } else {
            slideTitleElement.style.display = null;
            slideContentElement.style.display = null;
            slideTitleElement.style.backgroundColor = color;
            slideTitleElement.textContent = title;
            slideContentElement.textContent = content;
        }

    }

    async run() {
        let slidesRequest = fetch(location.origin + this.VideoWall.snippetPath + '?get=slides');
        let slidesResponse = await slidesRequest;
        let slidesResult = await slidesResponse.json();
        let slidesGenerator = Tools.getLoopGenerator(slidesResult);
        this.updateSlide(slidesGenerator);
        setInterval(() => { this.updateSlide(slidesGenerator) }, 15000);
    }
}

class VideosHandler {
    constructor(VideoWall) {
        this.VideoWall = VideoWall
        this.run().catch()
    }

    updateVideo(videosGenerator) {
        let videoTitleElement = document.querySelector('.video__title');
        let videoPlayerElement = document.querySelector('.video__player');
        let videoInfo = videosGenerator.next().value;
        videoTitleElement.textContent = videoInfo.title;
        videoPlayerElement.src = location.origin + '/' + videoInfo.src;
    }

    async run() {
        let videosRequest = fetch(location.origin + this.VideoWall.snippetPath + '?get=videos');
        let videosResponse = await videosRequest;
        let videosResult = await videosResponse.json();
        let videosGenerator = Tools.getLoopGenerator(videosResult);

        this.updateVideo(videosGenerator);
        let videoPlayerElement = document.querySelector('.video__player');
        videoPlayerElement.addEventListener('error', () => { this.updateVideo(videosGenerator) });
        videoPlayerElement.addEventListener('ended', () => { this.updateVideo(videosGenerator) });
    }
}

class VideoWallSimple {
    constructor() {
        this.snippetPath = '/assets/snippets/videowall-simple/videowall-simple.snippet.php'

        this.DailyHandler = new DailyHandler(this);
        this.SlidesHandler = new SlidesHandler(this);
        this.VideosHandler = new VideosHandler(this);
    }
}

new VideoWallSimple()
