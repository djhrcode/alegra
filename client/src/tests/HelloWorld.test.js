import HelloWorld from "../components/HelloWorld.vue"

import { render } from '@testing-library/vue'



describe('HelloWorld.vue', () => {
    test('fail', () => {
        const result = render(HelloWorld);
        
        expect(result.getByText("Volar")).toBeTruthy();
    })    
});

