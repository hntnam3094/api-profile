import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { Button } from "flowbite-react";
import { useForm as useFormInertial } from "@inertiajs/react";
import { useEffect } from "react";

export default function FormAdd({
    dataForm,
    structionForm,
    pageCode,
    code,
    id = 0
}) {
    const {
        register: registerRHF,
        handleSubmit: handleSubmitRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: dataForm });

    const { data, setData, post, errors } = useFormInertial();

    useEffect(() => {
        setData(buildStructionData(structionForm.form, dataForm));
    }, [structionForm.form]);

    useEffect(() => {
        watchRHF((value, { name, type }) => {
            setData(value);
        });
    }, [watchRHF]);

    function buildStructionData(structionForm, dataForm) {
        let obj = {};
        if (structionForm.form && structionForm.form.length > 0) {
            structionForm.form.forEach((ob, i) => {
                obj[ob.name] = dataForm[ob.name] ?? ob.value;
            });
        }

        return obj;
    }

    function onSubmit() {
        if (id) {
            post(route("structionpages.update", { id: id, page_code: pageCode, code: code }))
        } else {
            post(route("structionpages.store", { page_code: pageCode, code: code }))
        }
    }

    return (
        <OfficeLayout>
            <form onSubmit={handleSubmitRHF(onSubmit)}>
                <FormGeneration
                    form={structionForm.form}
                    register={registerRHF}
                    watch={watchRHF}
                    control={controlRHF}
                    errors={errors}
                    unregister={unregisterRHF}
                    setValue={setValueRHF}
                    isEdit={id}
                />

                <div className="flex gap-5">
                    <Button type="submit" color="success">Submit</Button>
                    <Button onClick={() => history.back()}>Back</Button>
                </div>
            </form>
        </OfficeLayout>
    );
}
