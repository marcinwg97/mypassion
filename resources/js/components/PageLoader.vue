<template>
    <div class="col-12">
        <div class="loader d-flex justify-content-center">
            <svg id="loader" xmlns="http://www.w3.org/2000/svg" style="height: 150px; width: 150px">
                <circle id="c" fill="none" stroke-width="8" stroke-linecap="round" stroke="#3FA7D6" cx="75" cy="75" r="70" />
            </svg>
        </div>
    </div>
</template>
<style lang="scss" scoped>
#loader {
	stroke-dasharray: 399.7405090332031px;
	stroke-dashoffset: 0;
	animation: heartBeat 5s linear reverse infinite;
	transform: rotate(-90deg);
}
@keyframes heartBeat {
	50% {
		stroke-dashoffset: 399.7405090332031px;
	}
	50.01% {
		stroke-dashoffset: -399.7405090332031px;
	}
}
</style>
