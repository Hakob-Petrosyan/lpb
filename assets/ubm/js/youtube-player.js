document.addEventListener('click', e => {
    const instVideoRate = 1.7678018575851393;
    const YTVideoRate = 0.562363238512035;
    const videoElement = e.target.closest('[data-modal-video-url]');
    if (videoElement) {
        e.preventDefault();
        e.stopPropagation();

        let frameWidth, frameHeight;

        let offsetForCloseButton = false;
        const screenOrientation = document.documentElement.clientHeight < document.documentElement.clientWidth?'landscape-primary':'portrait-primary';

        if(screenOrientation === 'landscape-primary'){
            if(videoElement.dataset.dimesionType === 'high'){
                frameHeight = document.documentElement.clientHeight;
                frameWidth = frameHeight / instVideoRate;
            }else{
                frameHeight = document.documentElement.clientHeight * 0.9;
                frameWidth = frameHeight / YTVideoRate;
            }
        }else{
            if(videoElement.dataset.dimesionType === 'high'){
                frameHeight = document.documentElement.clientHeight - 50;
                frameWidth = document.documentElement.clientWidth;
                offsetForCloseButton = true;
            }else{
                frameWidth = document.documentElement.clientWidth;
                frameHeight = frameWidth / instVideoRate;
            }
        }

        const youtubeLink = videoElement.dataset.modalVideoUrl;
        const frameHTML = `<iframe width="${frameWidth}px" height="${frameHeight}px" src="${youtubeLink}?wmode=opaque&autoplay=1"  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen></iframe>`;
        const youtubeFrameModalBg = document.createElement('div');
        youtubeFrameModalBg.innerHTML = frameHTML;
        document.body.appendChild(youtubeFrameModalBg);
        youtubeFrameModalBg.addEventListener('click', e => {
            youtubeFrameModalBg.remove();
        });

        youtubeFrameModalBg.classList.add('youtube-frame-modal-bg');
        if(offsetForCloseButton){
            youtubeFrameModalBg.classList.add('offset-for-close-button');
            const closeToolHTML = `<div data-close-modal-tool class="close-modal-tool" ><svg height="329pt" viewBox="0 0 329.26933 329" width="329pt" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg></div>`;
            const closeModelTool = createElementFromHTML(closeToolHTML);
            youtubeFrameModalBg.appendChild(closeModelTool);
            closeModelTool.addEventListener('click', e => {
                console.log(e.target);
                e.preventDefault();
                e.stopPropagation();
                youtubeFrameModalBg.remove();
                closeModelTool.remove();
            });
        }
    }
});


function createElementFromHTML(html){
    return (new DOMParser().parseFromString(html, 'text/html').body.childNodes[0]);
}